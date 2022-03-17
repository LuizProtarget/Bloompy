<?php
/**
 * Loja Virtual Model
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.Produtos.Model
 * @version	 1.0
 * @author	 Pronexo DevTeam <desenvolvimento@pronexo.com.br> Member Jingle
 * @link	 http://www.pronexo.com.br
 */
class LojaVirtual extends AppModel {
	public $name = 'LojaVirtual';
	public $useTable = "lojas_virtuais";
	
	public function updatePosition($loja_id,$position, $way)
	{
	
		$resultPosition = $this->query("select position from qa_lojas_virtuais LojaVirtual where id=".$loja_id);
		
		$myPostion 		= null;
		if(count($resultPosition) > 0)
			foreach($resultPosition as $tblPosition)
				foreach($tblPosition as $rowPosition)
					$myPostion = $rowPosition['position'];
		
		if(!is_null($myPostion))
		{
			if(!$way)
				$this->query("update qa_lojas_virtuais SET position=position-1 where position <= ".$position." and position >= ".$myPostion);
			else
				$this->query("update qa_lojas_virtuais SET position=position+1 where position >= ".$position." and position <= ".$myPostion);
				
			$this->query("update qa_lojas_virtuais SET position=".$position." where id=".$loja_id);
		}
	
		return true;
	}
}