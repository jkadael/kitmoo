<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Biblioteca de funciones y constantes que permite que el Módulo de Actividad Kitmoo trabaje integrado a Moodle
 *
 * @package    mod
 * @subpackage kitmoo
 * @copyright  2012 Jair Riaño, Andrés Rodríguez
 * @copyright  2012 DHumATIC - Universidad de los Llanos <http://www.unillanos.edu.co/>
 * @author     Jair Riaño <jkadael@gmail.com>
 * @author     Andrés Rodríguez <kiddavid180@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Evitar ejecución directa que revelaría mensajes de error en servidores mal configurados.
defined('MOODLE_INTERNAL') || die();

/**
 * Indica las características que soporta el módulo
 *
 * @param string $feature Constante (FEATURE_xx) de la característica
 * @return bool|null true si soporta la característica y null si no se conoce
 */
function kitmoo_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;

        default:
            return null;
    }
}

/**
 * Adiciona una nueva instancia del módulo en la Base de Datos
 *
 * @param object $kitmoo Datos enviados por el formulario
 * @return int Id de la nueva instancia
 */
function kitmoo_add_instance($kitmoo) {
    global $DB;

    $kitmoo->timecreated = time();

    return $DB->insert_record('kitmoo', $kitmoo);
}

/**
 * Actualiza una instancia del módulo en la Base de Datos
 *
 * @param object $kitmoo Datos enviados por el formulario
 * @return bool true si tiene éxito
 */
function kitmoo_update_instance($kitmoo) {
    global $DB;

    $kitmoo->timemodified = time();
    $kitmoo->id = $kitmoo->instance;

    return $DB->update_record('kitmoo', $kitmoo);
}

/**
 * Elimina una instancia del módulo en la Base de Datos
 *
 * @param int $id Id de la instancia del módulo
 * @return bool true en caso de éxito o false de lo contrario
 */
function kitmoo_delete_instance($id) {
    global $DB;

    // Obtenemos los datos de la instancia de kitmoo.
    if (!$kitmoo = $DB->get_record('kitmoo', array('id' => $id))) {
        return false;
    }

    $result = true;

    // Eliminamos todas las dependencias de la instancia de kitmoo.
    if (!$DB->delete_records('kitmoo_icon', array('kitmooid' => $kitmoo->id))) {
        $result = false;
    }

    if (!$DB->delete_records('kitmoo_theme', array('kitmooid' => $kitmoo->id))) {
        $result = false;
    }

    // Eliminamos la instancia de kitmoo.
    if (!$DB->delete_records('kitmoo', array('id' => $kitmoo->id))) {
        $result = false;
    }

    return $result;
}

/**
 * Información de resumen acerca de lo que un usuario ha hecho con una determinada instancia particular del módulo
 *
 * @param object $course
 * @param object $user
 * @param object $mod
 * @param object $kitmoo
 * @return null
 */
function kitmoo_user_outline($course, $user, $mod, $kitmoo) {
    return null;
}

/**
 * Información completa acerca de lo que un usuario ha hecho con una determinada instancia particular del módulo
 *
 * @param object $course
 * @param object $user
 * @param object $mod
 * @param object $kitmoo
 * @return bool true
 */
function kitmoo_user_complete($course, $user, $mod, $kitmoo) {
    return true;
}

/**
 * Teniendo en cuenta un curso y un tiempo, el módulo debe encontrar la actividad reciente que se ha producido en las actividades
 * de kitmoo e imprimirlo
 *
 * @param object $course
 * @param bool $viewfullnames
 * @param int $timestart
 * @return bool false
 */
function kitmoo_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;
}

/**
 * Realiza comprobaciones periódicas de acuerdo con el cron de Moodle
 *
 * @return bool true
 */
function kitmoo_cron() {
    return true;
}

/**
 * Devuelve un array de registros de usuarios que son participantes de una instancia dada del módulo
 *
 * @param int $kitmooid Id de la instancia del módulo
 * @return bool false
 */
function kitmoo_get_participants($kitmooid) {
    return false;
}

/**
 * Indica si una escala está siendo usada por una determinada instancia del módulo
 *
 * @param int $kitmooid Id de una instancia del módulo
 * @param int $scaleid Id de la escala a checkear
 * @return bool false
 */
function kitmoo_scale_used($kitmooid, $scaleid) {
    return false;
}

/**
 * Indica si una escala está siendo usada en cualquier instancia del módulo
 *
 * @param int $scaleid Id de la escala a checkear
 * @return bool false
 */
function kitmoo_scale_used_anywhere($scaleid) {
    return false;
}
