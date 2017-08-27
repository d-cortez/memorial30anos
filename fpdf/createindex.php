<?php
require('bookmark.php');

class PDF_Index extends PDF_Bookmark
{
function CreateIndex(){
	//Index title
	$this->SetFont('Arial','B',14);
	//$this->SetFontSize(15);
	$this->Cell(0,5,'ÍNDICE',0,1,'C');
	
	$this->Ln(10);

	$size=sizeof($this->outlines);
	$PageCellSize=$this->GetStringWidth($this->outlines[$size-1]['p'])+2;
	for ($i=0;$i<$size;$i++){
		//Offset
		$level=$this->outlines[$i]['l'];
		if($level>0)
			$this->Cell($level*8);

		//Caption
		$str=$this->outlines[$i]['t'];
		$strsize=$this->GetStringWidth($str);
		$avail_size=$this->w-$this->lMargin-$this->rMargin-$PageCellSize-($level*8)-4;
		while ($strsize>=$avail_size){
			$str=substr($str,0,-1);
			$strsize=$this->GetStringWidth($str);
		}
		$this->Cell($strsize+2,$this->FontSize+2,$str);

		//Filling dots
		$w=$this->w-$this->lMargin-$this->rMargin-$PageCellSize-($level*8)-($strsize+2);
		$nb=$w/$this->GetStringWidth('.');
		$dots=str_repeat('.',$nb);
		$this->Cell($w,$this->FontSize+2,$dots,0,0,'R');

		//Page number
		$this->Cell($PageCellSize,$this->FontSize+2,$this->outlines[$i]['p'],0,1,'R');
	}
}
}
?>
