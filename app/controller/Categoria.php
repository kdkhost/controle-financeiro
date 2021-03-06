<?php
/**
 * @author Peter Clayder
 */

namespace app\controller;

use app\models\Categoria as CategoriaModel;

/**
 * Class Categoria
 * @package app\controller
 */
class Categoria extends Controller
{

    /**
     * @var Categoria
     */
    private $categoria;

    /**
     * Categoria constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->pasta = "categoria";
        $this->categoria = new CategoriaModel();
    }

    /**
     * Controlador da página listar categorias.
     * @return void
     */
    public function index()
    {
        $this->carregarCss();
        $this->carregarJs();
        $dados['categorias'] = $this->categoria->getAll();
        $this->pagina("categorias", $dados);
    }

    /**
     * Método utilizado como API para gerar o gŕafico de pizza (Gasto por categoria). Requisição via GET.
     * @return void
     */
    public function graficoPizza()
    {
        echo json_encode($this->categoria->graficoPizza());
    }

    /**
     * Controlador para deletar categoria.
     * @return void
     */
    public function delete()
    {
        if (requisicao() === "POST") {
            $id = (isset($_POST['id'])) ? $_POST['id'] : 0;
            $id = (int)$id;
            if ($this->categoria->delete($id)) {
                flashData("excluirCategoria", mensagemAlerta("success", "Categoria excluída com sucesso"));
            } else {
                flashData("excluirCategoria", mensagemAlerta("danger", "Categoria não foi excluído"));
            }
            redirect("categoria", "index");

        } else {
            redirect("categoria", "index");
        }
    }

    /**
     * Página editar categoria.
     * @return void
     */
    public function editar()
    {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $dados['categoria'] = $this->categoria->get($id);
            $this->pagina("form-edit-categoria", $dados);
        } else {
            redirect("categoria", "index");
        }

    }

    /**
     * Página cadastrar categoria.
     * @return void
     */
    public function cadastrar()
    {
        $this->pagina("form-cadastrar-categoria");
    }

    /**
     * Controlador que efetua o cadastro de categoria.
     * @return void
     */
    public function realizarCadastro()
    {
        if (isset($_POST['nome'])) {
            $nome = $_POST['nome'];
            $dados = array(
                'nome' => $nome,
                'dateTime' => dateTime()
            );
            if ($this->categoria->insert($dados)) {
                flashData("cadastrarCategoria", mensagemAlerta("success", "Categoria cadastrado com sucesso."));
            } else {
                flashData("cadastrarCategoria", mensagemAlerta("danger", "Categoria não foi cadastrada."));
            }
        } else {
            flashData("cadastrarCategoria", mensagemAlerta("danger", "Campo nome obrigatório."));
        }
        redirect("categoria", "cadastrar");
    }

    /**
     * Controlador que efetua a edição da categoria.
     * @return void
     */
    public function realizarEdicao()
    {
        if (requisicao() === "POST") {
            $id = (isset($_POST['id'])) ? $_POST['id'] : 0;
            $id = (int)$id;
            if (isset($_POST['nome'])) {
                $nome = $_POST['nome'];
                if ($this->categoria->update($id, $nome)) {
                    flashData("editarCategoria", mensagemAlerta("success", "Categoria editada com sucesso."));
                } else {
                    flashData("editarCategoria", mensagemAlerta("danger", "Categoria não foi editada."));
                }
            } else {
                flashData("editarCategoria", mensagemAlerta("danger", "Campo nome obrigatório."));
            }

            redirect("categoria", "editar", "id=" . $id);

        } else {
            redirect("categoria", "index");
        }
    }

}