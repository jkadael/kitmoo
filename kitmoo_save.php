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
 * Guarda la información pertinente del entorno creado en la Base de Datos
 *
 * @package    mod
 * @subpackage kitmoo
 * @copyright  2012 Jair Riaño, Andrés Rodríguez
 * @copyright  2012 DHumATIC - Universidad de los Llanos <http://www.unillanos.edu.co/>
 * @author     Jair Riaño <jkadael@gmail.com>
 * @author     Andrés Rodríguez <kiddavid180@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/kitmoo/lib.php');
require_once($CFG->dirroot . '/mod/kitmoo/locallib.php');

// Se guarda el tema seleccionado en la Base de Datos.
if (isset($_POST['theme']) && isset($_POST['kitmooid'])) {
    // Establecemos todas las variables.
    $kitmooid = $_POST['kitmooid'];
    $theme = $_POST['theme'];
    $record = new stdClass();
    $record->theme = $theme;

    // Se va insertar el tema por primera vez.
    if (!kitmoo_get_theme($kitmooid)) {
        kitmoo_insert_theme($kitmooid, $record);
    // Se actualiza un tema ya guardado.
    } else {
        kitmoo_update_theme($kitmooid, $record);
    }

// Se guarda la posición actual del ícono en la Base de Datos.
} else if (isset($_POST['idicon']) && isset($_POST['top']) && isset($_POST['left'])) {
    // Establecemos todas las variables.
    $idicon = $_POST['idicon'];
    $top = $_POST['top'];
    $left = $_POST['left'];
    $record = new stdClass();
    $record->positiontop = $top . 'px';
    $record->positionleft = $left . 'px';

    kitmoo_update_icon($idicon, $record);

// Se elimina un ícono de la Base de Datos.
} else if (isset($_POST['idicon'])) {
    // Establecemos todas las variables.
    $idicon = $_POST['idicon'];

    kitmoo_delete_icon($idicon);

// Se confirma todos los cambios realizados en el kit.
} else if (isset($_POST['ready']) && isset($_POST['kitmooid']) && isset($_POST['course'])) {
    // Establecemos todas las variables.
    $kitmooid = $_POST['kitmooid'];
    $course = $_POST['course'];

    kitmoo_create_environments($kitmooid);

    redirect("$CFG->wwwroot/course/view.php?id=$course");
}