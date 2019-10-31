<?php

/**
 * Description of Redmine
 *
 * @author tiagoc
 */
class Glpi extends DatabaseGlpi {

    
    function __construct() {
        
    }

    function listaComputadores() {
        $consulta = "SELECT loc.completename as localizacao, comp.name as nome_comp, comp.serial, typ.name as tipo_equip, fab.name as fabricante, modl.name as modelo, sit.name as situacao, comp.contact as usuario, comp.date_mod FROM glpi_locations AS loc JOIN glpi_computers AS comp ON loc.id = comp.locations_id JOIN glpi_computermodels AS modl ON modl.id = comp.computermodels_id JOIN glpi_computertypes as typ on typ.id = comp.computertypes_id JOIN glpi_manufacturers as fab on fab.id = comp.manufacturers_id JOIN glpi_states as sit on comp.states_id = sit.id WHERE loc.completename LIKE '%%' ORDER BY loc.completename, comp.name;";
        $resultado = mysqli_query($this->connectGlpi(), $consulta);
        return $resultado;
    }

    function __destruct() {
        
    }

}
