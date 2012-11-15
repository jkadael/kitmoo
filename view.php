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
 * Página de inicio de la actividad de una instancia de Kitmoo en particular
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

// Obtener parámetros opcionales.
$id = optional_param('id', 0, PARAM_INT);   // Id del curso_módulo.
$k  = optional_param('k', 0, PARAM_INT);    // Id de la instancia del módulo.

// Obtenemos los datos necesarios a partir de los parámetros opcionales.
if ($id) {

    if (!$cm = get_coursemodule_from_id('kitmoo', $id)) {
        print_error('invalidcoursemodule');
    }

    if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
        print_error('coursemisconf');
    }

    if (!$kitmoo = $DB->get_record('kitmoo', array('id' => $cm->instance))) {
        print_error('invalidid', 'kitmoo');
    }

} else if ($k) {

    if (!$kitmoo = $DB->get_record('kitmoo', array('id' => $k))) {
        print_error('invalidid', 'kitmoo');
    }

    if (!$course = $DB->get_record('course', array('id' => $kitmoo->course))) {
        print_error('coursemisconf');
    }

    if (!$cm = get_coursemodule_from_instance('kitmoo', $kitmoo->id, $course->id)) {
        print_error('invalidcoursemodule');
    }

} else {
    print_error('incorrectparameters');
}

// Login requerido para el acceso a esta página.
require_login($course, true, $cm);

// Obtenemos el contexto de la instancia.
$context = get_context_instance(CONTEXT_MODULE, $cm->id);

// Adicionamos, al log de Moodle, que se ha visto esta página.
add_to_log($course->id, 'kitmoo', 'view', "view.php?id=$cm->id", $kitmoo->id, $cm->id);

// Configuramos la página.
$PAGE->set_url('/mod/kitmoo/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($kitmoo->name));
$PAGE->set_heading($course->fullname);
$PAGE->set_context($context);
$PAGE->set_pagelayout('report');

// Pintamos la cabecera de la página.
echo $OUTPUT->header();

// Condiciones para mostrar la intro.
if ($kitmoo->intro) {
    echo $OUTPUT->box(format_module_intro('kitmoo', $kitmoo, $cm->id), 'generalbox', 'intro');
}

// Conocer que puede hacer el usuario en el módulo.
$isview = has_capability('mod/kitmoo:view', $context);
$iscreate = has_capability('mod/kitmoo:create', $context);

// Mostramos las distintas vistas.
if ($iscreate) {
    kitmoo_show_view($kitmoo->id, true);
} else if ($isview) {
    kitmoo_show_view($kitmoo->id, false);
}

// Pintamos el pie de página.
echo $OUTPUT->footer();
