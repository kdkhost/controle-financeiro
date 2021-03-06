<?php
/**
 * @author Peter Clayder
 */
namespace app\controller;
use app\models\Cliente;
use app\models\ContaPagar as Pagar;
use app\models\ContaReceber as Receber;

/**
 * Class Home
 * @package app\controller
 */
class Home extends Controller
{

	/**
	 * @var ContaPagar
	 */
	private $pagar;

	/**
	 * @var Cliente 
	 */
	private $cliente;

	/**
	 * @param ContaReceber
	 */
	private $receber;

    /**
     * Home constructor.
     */
	public function __construct(){
		parent::__construct();
		$this->pasta = "home";
		$this->pagar = new Pagar();
        $this->receber = new Receber();
	}

    /**
     * Página home
     * @return void
     */
	public function index(){
		$this->cliente = new Cliente();
		$dados['qtdClientes'] = $this->cliente->qtdClientes();
		$dados['somaValoresPagar'] = $this->pagar->somarValores();
		$dados['somaValoresReceber'] = $this->receber->somarValores();
		$dados['contas'] = $this->pagar->contasPagar30Dias();
		$dados['contasReceber'] = $this->receber->contasReceber30Dias();

		$this->carregarCss();
		$this->carregarJs();
		$this->pagina("home", $dados);
	}

    /**
     * Método utilizado como API para gerar o gŕafico de barra. Requisição via GET.
     * @return void
     */
	public function graficoBarra(){
        $anoAtual = dateTime("Y");
        $grafico['pagar'] = $this->pagar->graficoBarra($anoAtual);
        $grafico['receber'] = $this->receber->graficoBarra($anoAtual);
        echo json_encode($grafico);
    }

    /**
     * @return void
     */
	public function carregarCss(){
        $this->setScripHeader(inserirCss("bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css"));
        $this->setScripHeader(inserirCss("jqvmap/dist/jqvmap.min.css"));
        $this->setScripHeader(inserirCss("bootstrap-daterangepicker/daterangepicker.css"));
    }

    /**
     * @return void
     */
    public function carregarJs(){
        $this->setScripFooter("<script src=\"".baseUrl("assets/js/graficos/grafico-barra.js")."\"></script> \n");
        $this->setScripFooter("<script src=\"".baseUrl("assets/js/graficos/grafico-pizza.js")."\"></script> \n");
        $this->setScripFooter("<script src=\"".baseUrl("assets/js/graficos/carregar.js")."\"></script> \n");
        $this->setScripFooter(inserirJs("Chart.js/dist/Chart.min.js"));
	    $this->setScripFooter(inserirJs("gauge.js/dist/gauge.min.js"));
	    $this->setScripFooter(inserirJs("bootstrap-progressbar/bootstrap-progressbar.min.js"));
	    $this->setScripFooter(inserirJs("iCheck/icheck.min.js"));
	    $this->setScripFooter(inserirJs("skycons/skycons.js"));
	    $this->setScripFooter(inserirJs("Flot/jquery.flot.js"));
	    $this->setScripFooter(inserirJs("Flot/jquery.flot.pie.js"));
	    $this->setScripFooter(inserirJs("Flot/jquery.flot.time.js"));
	    $this->setScripFooter(inserirJs("Flot/jquery.flot.stack.js"));
	    $this->setScripFooter(inserirJs("Flot/jquery.flot.resize.js"));
	    $this->setScripFooter(inserirJs("flot.orderbars/js/jquery.flot.orderBars.js"));
	    $this->setScripFooter(inserirJs("flot-spline/js/jquery.flot.spline.min.js"));
	    $this->setScripFooter(inserirJs("flot.curvedlines/curvedLines.js"));
	    $this->setScripFooter(inserirJs("DateJS/build/date.js"));
	    $this->setScripFooter(inserirJs("moment/min/moment.min.js"));
	    $this->setScripFooter(inserirJs("bootstrap-daterangepicker/daterangepicker.js"));
    }
}





	