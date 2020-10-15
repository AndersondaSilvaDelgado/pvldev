<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../model/dao/EquipDAO.class.php');
require_once('../model/dao/FuncionarioDAO.class.php');
require_once('../model/dao/ItemCheckListDAO.class.php');

class BaseDadosCTR {
    
    private $base = 1;

    public function dadosEquip($versao, $info) {

        $versao = str_replace("_", ".", $versao);
        
        if($versao >= 1.00){
        
            $equipDAO = new EquipDAO();

            $dado = $info['dado'];

            $dadosEquip = array("dados" => $equipDAO->dados($dado, $this->base));
            $resEquip = json_encode($dadosEquip);
            
            return $resEquip;
        
        }
        
    }
    
    public function dadosFuncionario($versao) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 1.00){
            
            $funcionarioDAO = new FuncionarioDAO();
        
            $dados = array("dados"=>$funcionarioDAO->dados($this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }
    
    public function atualItemCheckList($versao, $info) {

        $versao = str_replace("_", ".", $versao);
        
        if($versao >= 1.00){
        
            $equipDAO = new EquipDAO();
            $itemCheckListDAO = new ItemCheckListDAO();

            $nroEquip = $info['dado'];

            $dadosEquip = array("dados" => $equipDAO->dados($nroEquip));
            $resEquip = json_encode($dadosEquip);

            $dadosItemCheckList = array("dados" => $itemCheckListDAO->dados());
            $resItemCheckList = json_encode($dadosItemCheckList);

            $itemCheckListDAO->atualCheckList($nroEquip);
            
            return $resEquip . "_" . $resItemCheckList;
        
        }
        
    }
    
    public function dadosItemCheckList($versao) {
        
        $versao = str_replace("_", ".", $versao);
       
        if($versao >= 1.00){
            
            $itemCheckListDAO = new ItemCheckListDAO();
        
            $dados = array("dados"=>$itemCheckListDAO->dados($this->base));
            $json_str = json_encode($dados);

            return $json_str;
        
        }
        
    }
    
}
