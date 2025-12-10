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

    // Função auxiliar para converter strings de data/hora (principalmente do input datetime-local)
    private function _formatDateForDatabase($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        // Normalizar o formato do input datetime-local: YYYY-MM-DDTHH:MM

        // 1. Remove o 'T' e adiciona espaço
        $formattedDate = str_replace('T', ' ', trim($dateString));

        // 2. Adiciona segundos ':00' se não houver segundos (pois o input só vai até minutos)
        if (substr_count($formattedDate, ':') === 1) {
            $formattedDate .= ':00';
        }

        // Tenta criar um objeto DateTime no formato correto para garantir a limpeza
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $formattedDate);

        if ($dateTime instanceof \DateTime) {
            return $dateTime->format('Y-m-d H:i:s');
        }

        // Se falhar (o que é raro se o seletor foi usado), retornamos null para falhar o 'required'
        return null;
    }


    /**
     * Lista todos os eventos (Página principal da agenda)
     */
    public function index()
    {
        // Obtém todos os eventos do banco de dados
        $data['events'] = $this->eventModel->findAll();

        // Carrega a view para exibir a lista de eventos
        return view('events/index', $data);
    }

    /**
     * Exibe os detalhes de um evento específico
     * @param int|null $id ID do evento
     */
    public function show($id = null)
    {
        if (is_null($id) || ! $data['event'] = $this->eventModel->find($id)) {
            // Se o ID for nulo ou o evento não for encontrado, redireciona ou mostra erro
            return redirect()->back()->with('error', 'Evento não encontrado.');
        }

        return view('events/show', $data);
    }

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
        // 1. Coleta os dados do formulário
        $data = $this->request->getPost();

        // 2. Formata as datas (necessário para o MySQL/MariaDB)
        $data['start_time'] = $this->_formatDateForDatabase($data['start_time']);
        $data['end_time'] = $this->_formatDateForDatabase($data['end_time']);

        // 3. Valida os dados (REMOVEU-SE o 'valid_date' estrito para resolver o erro)
        if (! $this->validate([
            'title' => 'required|min_length[3]',
            'start_time' => 'required', // Apenas checa se está preenchido
        ])) {
            // Se a validação falhar, retorna ao formulário com erros
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 4. Salva os dados no banco de dados usando o Model
        if ($this->eventModel->insert($data)) {
            return redirect()->to('/events')->with('success', 'Evento criado com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Erro ao salvar o evento.');
        }
    }

    /**
     * Exibe o formulário de edição de um evento existente
     * @param int|null $id ID do evento
     */
    public function edit($id = null)
    {
        if (is_null($id) || ! $data['event'] = $this->eventModel->find($id)) {
            return redirect()->back()->with('error', 'Evento não encontrado.');
        }

        // Formata a data para exibir no campo datetime-local (necessário T)
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
     * @param int $id ID do evento a ser atualizado
     */
    public function update($id)
    {
        // 1. Coleta os dados e valida
        $data = $this->request->getPost();

        // 2. Formata as datas
        $data['start_time'] = $this->_formatDateForDatabase($data['start_time']);
        $data['end_time'] = $this->_formatDateForDatabase($data['end_time']);

        // 3. Valida os dados (REMOVEU-SE o 'valid_date' estrito)
        if (! $this->validate([
            'title' => 'required|min_length[3]',
            'start_time' => 'required', // Apenas checa se está preenchido
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 4. Atualiza os dados no banco
        if ($this->eventModel->update($id, $data)) {
            return redirect()->to('/events')->with('success', 'Evento atualizado com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Erro ao atualizar o evento.');
        }
    }

    /**
     * Exclui um evento
     * @param int $id ID do evento a ser excluído
     */
    public function delete($id)
    {
        if ($this->eventModel->delete($id)) {
            return redirect()->to('/events')->with('success', 'Evento excluído com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Erro ao excluir o evento.');
        }
    }
}
