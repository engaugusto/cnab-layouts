<?php

namespace CnabParser\Model;

use CnabParser\Parser\Layout;

class Remessa extends IntercambioBancarioAbstract
{
	public $detalhes;

	public function __construct(Layout $layout)
	{
		parent::__construct($layout);

		$remessaLayout = $this->layout->getRemessaLayout();

		$this->header_arquivo = new \stdClass;
		$this->trailer_arquivo = new \stdClass;
		$this->header_lote = new \stdClass;
		$this->trailer_lote = new \stdClass;
		$this->detalhes = array();
		
		if (isset($remessaLayout['header_arquivo'])) {
			foreach ($remessaLayout['header_arquivo'] as $field => $definition) {
				$this->header_arquivo->$field = (isset($definition['default'])) ? $definition['default'] : '';
			}
		}

		if (isset($remessaLayout['trailer_arquivo'])) {
			foreach ($remessaLayout['trailer_arquivo'] as $field => $definition) {
				$this->trailer_arquivo->$field = (isset($definition['default'])) ? $definition['default'] : '';
			}
		}

		if (isset($remessaLayout['header_lote'])) {
			foreach ($remessaLayout['header_lote'] as $field => $definition) {
				$this->header_lote->$field = (isset($definition['default'])) ? $definition['default'] : '';
			}
		}

		if (isset($remessaLayout['trailer_lote'])) {
			foreach ($remessaLayout['trailer_lote'] as $field => $definition) {
				$this->trailer_lote->$field = (isset($definition['default'])) ? $definition['default'] : '';
			}
		}
	}

	public function novoDetalhe()
	{
		$remessaLayout = $this->layout->getRemessaLayout();
		$detalhe = new \stdClass;
		if (isset($remessaLayout['detalhes'])) {
			foreach ($remessaLayout['detalhes'] as $segmento => $segmentoDefinitions) {
				$detalhe->$segmento = new \stdClass;
				foreach ($segmentoDefinitions as $field => $definition) {
					$detalhe->$segmento->$field = (isset($definition['default'])) ? $definition['default'] : '';
				}
			}
		}
		return $detalhe;
	}

	public function inserirDetalhe(\stdClass $detalhe)
	{
		$this->detalhes[] = $detalhe;
		return $this;
	}

	public function countDetalhes()
	{
		return count($this->detalhes);
	}

	public function limpaDetalhes()
	{
		$this->detalhes = array();
		return $this;
	}
}