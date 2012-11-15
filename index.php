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
 * Página que muestra todas las instancias del Módulo de Actividad Kitmoo en un curso en particular
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
require_once('lib.php');

// Obtener la id del curso sobre el que mostrar la lista de instancias.
$id = required_param('id', PARAM_INT);

// Seteamos la URL de la página.
$PAGE->set_url('/mod/kitmoo/index.php', array('id' => $id));

// Obtenemos los datos del curso.
if (!$course = $DB->get_record('course', array('id' => $id))) {
    print_error('Course ID is incorrect');
}

// Login requerido para el acceso a esta página.
require_course_login($course);

// Seteamos layout de la página.
$PAGE->set_pagelayout('incourse');

// Adicionamos, al log de Moodle, que se ha visto esta página.
add_to_log($course->id, 'kitmoo', 'view all', "index.php?id=$course->id", '');

$strkitmoos = get_string('modulenameplural', 'kitmoo');

// Configuramos la página.
$PAGE->navbar->add($strkitmoos);
$PAGE->set_title($strkitmoos);
$PAGE->set_heading($course->fullname);

// Pintamos la cabecera de la página.
echo $OUTPUT->header();

// Obtenemos todos los datos pertinentes.
if (!$kitmoos = get_all_instances_in_course('kitmoo', $course)) {
    notice(get_string('nokitmoos', 'kitmoo'), "../../course/view.php?id=$course->id");
    exit;
}

$usesections = course_format_uses_sections($course->format);
if ($usesections) {
    $sections = get_all_sections($course->id);
}

// Creamos una tabla HTML con los datos obtenidos anteriormente.
$timenow = time();
$strsectionname = get_string('sectionname', 'format_' . $course->format);
$strname = get_string('name');
$table = new html_table();

if ($usesections) {
    $table->head = array($strsectionname, $strname);
} else {
    $table->head = array($strname);
}

foreach ($kitmoos as $kitmoo) {
    $linkcss = null;

    if (!$kitmoo->visible) {
        $linkcss = array('class' => 'dimmed');
    }

    $link = html_writer::link(new moodle_url('/mod/kitmoo/view.php', array('id' => $kitmoo->coursemodule)), $kitmoo->name, $linkcss);

    if ($usesections) {
        $table->data[] = array(get_section_name($course, $sections[$kitmoo->section]), $link);
    } else {
        $table->data[] = array($link);
    }
}

// Pintamos la tabla en la página.
echo html_writer::table($table);

// Pintamos el pie de página.
echo $OUTPUT->footer();
