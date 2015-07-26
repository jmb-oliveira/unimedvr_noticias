<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_noticias extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function countNoticias($busca)
	{		
		$query = $this->db->join('unmd_categorias t2', 't1.id_categoria = t2.id_categoria', 'inner')
						->where('t1.removed_on IS NULL')
						->where('t2.removed_on IS NULL');

		if($busca != 'sem_busca')
			$query->like('titulo', $busca);
							
		$result = $query->count_all_results('unmd_noticias t1');

		return $result;
	}
	function getNoticias($busca, $inicio, $offset)
	{
		$query = $this->db->select(array('t1.id_noticia', 't1.titulo', 't1.texto', 't1.publicada_em'))
						  ->from('unmd_noticias t1')
						  ->join('unmd_categorias t2', 't1.id_categoria = t2.id_categoria', 'inner')
				 		  ->where('t1.removed_on IS NULL')
				 		  ->where('t2.removed_on IS NULL');						 
			
		if($busca != 'sem_busca')
			$query->like('t1.titulo', $busca);

		$result = $query->limit($offset, $inicio)
			  			->order_by('t1.publicada_em', 'DESC')
			  			->get()
			  			->result();

		return $result;
	}
}