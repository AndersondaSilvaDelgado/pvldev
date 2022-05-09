<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../model/dao/EquipDAO.class.php');
require_once('../model/dao/ItemCheckListDAO.class.php');
require_once('../model/dao/CabecCheckListDAO.class.php');
require_once('../model/dao/RespCheckListDAO.class.php');
/**
 * Description of CheckListCTR
 *
 * @author anderson
 */
class CheckListCTR {
    
    private $base = 2;
    
    public function salvarDados($info) {

        $dados = $info['dado'];

        $posicao = strpos($dados, "_") + 1;
        $cabec = substr($dados, 0, ($posicao - 1));
        $resp = substr($dados, $posicao);

        $jsonObjCabec = json_decode($cabec);
        $jsonObjResp = json_decode($resp);

        $dadosCabec = $jsonObjCabec->cabecalho;
        $dadosResp = $jsonObjResp->resp;

        return $this->salvarCabec($dadosCabec, $dadosResp);

    }
    
    private function salvarCabec($dadosCab, $dadosItem) {
        $cabecCheckListDAO = new CabecCheckListDAO();
        $idCabecArray = array();
        foreach ($dadosCab as $cabec) {
            $v = $cabecCheckListDAO->verifCabecCheckList($cabec);
            if ($v == 0) {
                $cabecCheckListDAO->insCabecCheckList($cabec);
            }
            $idCabec = $cabecCheckListDAO->idCabecCheckList($cabec);
            $this->salvarResp($idCabec, $cabec->idCabecCheckList, $dadosItem);
            $idCabecArray[] = array("idCabecCheckList" => $cabec->idCabecCheckList);
        }
        $dadoCabec = array("cabec"=>$idCabecArray);
        $retCabec = json_encode($dadoCabec);
        
        return 'GRAVOU-CHECKLIST_' . $retCabec;
    }
    
    private function salvarResp($idCabecBD, $idCabecCel, $dadosResp) {
        $respCheckListDAO = new RespCheckListDAO();
        foreach ($dadosResp as $resp) {
            if ($idCabecCel == $resp->idCabecItCheckList) {
                $v = $respCheckListDAO->verifRespCheckList($idCabecBD, $resp, $this->base);
                if ($v == 0) {
                    $respCheckListDAO->insRespCheckList($idCabecBD, $resp, $this->base);
                }
            }
        }
    }
    
}
