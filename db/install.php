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
 * Realiza tareas específicas posterior a la instalación del Módulo de Actividad Kitmoo
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
 * Procedimiento posterior a la instalación del módulo
 */
function xmldb_kitmoo_install() {

    // Copiar archivo kitmoo_modedit.php para crear los recursos y actividades.
    copy($CFG->wwwroot . "/mod/kitmoo/kitmoo_modedit.php", $CFG->wwwroot . "/course/kitmoo_modedit.php");
}

/**
 * Procedimiento de recuperación posterior a la instalación del módulo
 */
function xmldb_kitmoo_install_recovery() {
    // Código necesario aquí.
}
