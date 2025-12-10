<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel; // Importa o EventModel criado
use CodeIgniter\HTTP\ResponseInterface;

class Events extends BaseController
{
    // Propriedade para armazenar a instância do Model
    protected $eventModel;

    // Construtor: Inicializa e injeta o Model
    public function __construct()
    {
        // Instancia o EventModel
        $this->eventModel = new EventModel();
    }

    // Função auxiliar para converter strings de data/hora
    private function _formatDateForDatabase($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        $formattedDate = str_replace('T', ' ', trim($dateString));

        if (substr_count($formattedDate, ':') === 1) {
            $formattedDate .= ':00';
        }

        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $formattedDate);

        if ($dateTime instanceof \DateTime) {
            return $dateTime->format('Y-m-d H:i:s');
        }

        return null;
    }


    /**
     * Lista todos os eventos DO USUÁRIO LOGADO (Página principal da agenda)
     */
    public function index()
    {
        $userId = session()->get('id');

        $data['events'] = $this->eventModel
            ->builder()
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();

        return view('events/index', $data);
    }

    // --------------------------------------------------------------------
    // NOVO: Função para fornecer dados JSON ao FullCalendar
    // --------------------------------------------------------------------

    /**
     * Fornece os eventos do usuário logado em formato JSON para o FullCalendar.
     */
    public function getEventsJson()
    {
        $userId = session()->get('id');
        $events = $this->eventModel->where('user_id', $userId)->findAll();
        $calendarData = [];

        foreach ($events as $event) {
            $calendarData[] = [
                'title' => $event['name'] ?? $event['title'], // Usa 'name' ou 'title' como fallback
                'start' => $event['start_time'],
                'end' => $event['end_time'],
                'id' => $event['id'],
                'className' => $this->getStatusClass($event['status']),
                'url' => base_url('events/' . $event['id']),
            ];
        }

        return $this->response->setJSON($calendarData);
    }

    /**
     * Função auxiliar para mapear status do DB para classes CSS
     */
    private function getStatusClass($status)
    {
        switch ($status) {
            case 'concluída':
                return 'event-completed';
            case 'cancelada':
            case 'cancelado':
                return 'event-cancelled';
            case 'pendente':
            default:
                return 'event-pending';
        }
    }

    // --------------------------------------------------------------------
    // CRUD: CREATE
    // --------------------------------------------------------------------

    /**
     * Exibe o formulário para criar um novo evento
     */
    public function new()
    {
        return view('events/new');
    }

    /**
     * Processa a submissão do formulário e salva o novo evento
     */
    public function create()
    {
        $userId = session()->get('id');
        $input = $this->request->getPost();

        // 1. Validação: Agora validamos o campo 'title' que vem do formulário
        if (! $this->validate([
            'title' => 'required|min_length[3]', // <-- VAI PROCURAR O CAMPO 'title'
            'start_time' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Monta o array de dados para Inserção
        $data = [
            'user_id' => $userId,
            'name' => $input['title'], // <-- RENOMEIA DE 'title' PARA 'name' AQUI
            'description' => $input['description'] ?? null,
            'start_time' => $this->_formatDateForDatabase($input['start_time']),
            'end_time' => $this->_formatDateForDatabase($input['end_time'] ?? null),
            'status' => 'pendente',
        ];

        // 3. Salva no banco de dados
        if ($this->eventModel->insert($data)) {
            return redirect()->to('/events')->with('success', 'Evento criado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao salvar o evento.');
        }
    }

    // --------------------------------------------------------------------
    // CRUD: SHOW, EDIT, UPDATE, DELETE (Mantidos com autorização)
    // --------------------------------------------------------------------

    /**
     * Exibe os detalhes de um evento específico
     */
    public function show($id = null)
    {
        if (is_null($id) || ! $data['event'] = $this->eventModel->find($id)) {
            return redirect()->to('/events')->with('error', 'Evento não encontrado.');
        }
        if ($data['event']['user_id'] != session()->get('id')) {
            return redirect()->to('/events')->with('error', 'Acesso negado: Este evento não é seu.');
        }
        return view('events/show', $data);
    }

    /**
     * Exibe o formulário de edição de um evento existente
     */
    public function edit($id = null)
    {
        if (is_null($id) || ! $data['event'] = $this->eventModel->find($id)) {
            return redirect()->to('/events')->with('error', 'Evento não encontrado.');
        }
        if ($data['event']['user_id'] != session()->get('id')) {
            return redirect()->to('/events')->with('error', 'Você só pode editar seus próprios eventos.');
        }

        // Formata a data para exibir no campo datetime-local
        if (!empty($data['event']['start_time'])) {
            $data['event']['start_time'] = str_replace(' ', 'T', substr($data['event']['start_time'], 0, 16));
        }
        if (!empty($data['event']['end_time'])) {
            $data['event']['end_time'] = str_replace(' ', 'T', substr($data['event']['end_time'], 0, 16));
        }

        return view('events/edit', $data);
    }

    /**
     * Processa a submissão do formulário e atualiza o evento
     */
    public function update($id)
    {
        if (is_null($id) || ! $event = $this->eventModel->find($id)) {
            return redirect()->to('/events')->with('error', 'Evento não encontrado.');
        }
        if ($event['user_id'] != session()->get('id')) {
            return redirect()->to('/events')->with('error', 'Você só pode editar seus próprios eventos.');
        }

        $input = $this->request->getPost();

        // Validação
        if (! $this->validate([
            'title' => 'required|min_length[3]',
            'start_time' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Monta o array de atualização
        $data = [
            'name' => $input['title'],
            'description' => $input['description'] ?? null,
            'start_time' => $this->_formatDateForDatabase($input['start_time']),
            'end_time' => $this->_formatDateForDatabase($input['end_time'] ?? null),
            'status' => $input['status'] ?? $event['status'],
        ];

        // 6. Atualiza os dados no banco
        if ($this->eventModel->update($id, $data)) {
            return redirect()->to('/events')->with('success', 'Evento atualizado com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Erro ao atualizar o evento.');
        }
    }

    /**
     * Exclui um evento
     */
    public function delete($id)
    {
        if (is_null($id) || ! $event = $this->eventModel->find($id)) {
            return redirect()->to('/events')->with('error', 'Evento não encontrado.');
        }
        if ($event['user_id'] != session()->get('id')) {
            return redirect()->to('/events')->with('error', 'Você só pode excluir seus próprios eventos.');
        }

        if ($this->eventModel->delete($id)) {
            return redirect()->to('/events')->with('success', 'Evento excluído com sucesso.');
        } else {
            return redirect()->to('/events')->with('error', 'Erro ao excluir o evento.');
        }
    }
}
