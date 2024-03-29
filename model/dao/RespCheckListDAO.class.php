<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../dbutil/Conn.class.php');
/**
 * Description of ItemCheckList
 *
 * @author anderson
 */
class RespCheckListDAO extends Conn {

    public function verifRespCheckList($idCab, $item) {

        $select = " SELECT "
                . " COUNT(*) AS QTDE "
                . " FROM "
                . " ITEM_BOLETIM_CHECK "
                . " WHERE "
                . " ID_BOLETIM = " . $idCab
                . " AND "
                . " ITMANPREV_ID = " . $item->idItBDItCheckList;

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $it) {
            $v = $it['QTDE'];
        }

        return $v;
    }

    public function insRespCheckList($idCab, $item) {

        $grupo = '';
        $questao = '';

        $select = " SELECT "
                . " VIPC.ITMANPREV_ID AS ID, "
                . " CARACTER(VIPC.PROC_OPER) AS QUESTAO, "
                . " CARACTER(VCC.DESCR) AS GRUPO "
                . " FROM "
                . " V_ITEM_PLANO_CHECK VIPC "
                . " , V_COMPONENTE_CHECK VCC "
                . " WHERE "
                . " VIPC.ITMANPREV_ID = " . $item->idItBDItCheckList . " "
                . " AND "
                . " VIPC.COMPONENTE_ID = VCC.COMPONENTE_ID ";

        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
        $this->Read->execute();
        $result = $this->Read->fetchAll();

        foreach ($result as $inf) {
            $questao = $inf['QUESTAO'];
            $grupo = $inf['GRUPO'];
        }

        if (!isset($item->opItCheckList) || empty($item->opItCheckList)) {
            $item->opItCheckList = 0;
        }

        $sql = " INSERT INTO ITEM_BOLETIM_CHECK ( "
                . " ID_BOLETIM "
                . " , GRUPO "
                . " , QUESTAO "
                . " , RESP_CD "
                . " , ITMANPREV_ID "
                . " ) "
                . " VALUES ( "
                . " " . $idCab . " "
                . " , '" . $grupo . "' "
                . " , '" . $questao . "' "
                . " , " . $item->opItCheckList . " "
                . " , " . $item->idItBDItCheckList . ")";

        $this->Create = $this->Conn->prepare($sql);
        $this->Create->execute();
    }

}
