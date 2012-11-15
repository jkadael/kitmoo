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
 * Biblioteca de funciones específicas o propias del Módulo de Actividad Kitmoo
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

require_once($CFG->dirroot . '/mod/kitmoo/lib.php');

/**
 * Muestra la actividad en forma gráfica (fondos, íconos, enlaces, etc.)
 *
 * @param int $kitmooid Instancia de kitmoo
 * @param bool $view Posee permiso para editar
 */
function kitmoo_show_view($kitmooid, $view) {
    global $CFG;

    echo '<p>' . get_string('info', 'kitmoo') . '</p>';

    // Buscamos si existe un tema personalizado.
    $kitmootheme = kitmoo_get_theme($kitmooid);

    if (!$kitmootheme) {
        $kitmootheme = 'pix/default.gif';
    }

    // Empezamos a pintar el entorno.
    echo '<div id="container" style="background:url(' . $kitmootheme . ');">';

    // Buscamos si existen íconos a mostrar.
    if ($kitmoosicons = kitmoo_get_icons($kitmooid)) {
        foreach ($kitmoosicons as $kitmooicon) {
            echo '<div class="icon" style="top:' . $kitmooicon->positiontop . ';left:' . $kitmooicon->positionleft . ';">';
            echo '<a href="' . $kitmooicon->url . '" title="' . get_string('advice', 'kitmoo') . '">';
            echo '<img src="' . $kitmooicon->source . '" alt="[' . $kitmooicon->type . ']" height="64" width="64" />';
            echo '</a>';
            echo '</div>';
        }
    }

    echo '</div>';

    // Permiso para editar.
    if ($view) {
        echo '<a href="' . $CFG->wwwroot . '/mod/kitmoo/create.php?id=' . $kitmooid. '" class="button_link" title="' . get_string('buttoncreate', 'kitmoo') . '">' . get_string('buttoncreate', 'kitmoo') . '</a>';
    }
}

/**
 * Busca todos los íconos que posee una instancia de kitmoo
 *
 * @param int $kitmooid Instancia de kitmoo
 * @return array Array de objetos de información de íconos
 */
function kitmoo_get_icons($kitmooid) {
    global $DB;

    return $DB->get_records('kitmoo_icon', array('kitmooid' => $kitmooid));
}

/**
 * Adiciona los íconos de una instancia de kitmoo en la Base de Datos
 *
 * @param int $kitmooid Instancia de kitmoo
 * @param object $kitmooicon Icono a guardar
 */
function kitmoo_insert_icon($kitmooid, $kitmooicon) {
    global $DB;

    $kitmooicon->kitmooid = $kitmooid;

    $DB->insert_record('kitmoo_icon', $kitmooicon, false);
}

/**
 * Actualiza el ícono de una instancia de kitmoo en la Base de Datos
 *
 * @param int $idicon Id del ícono
 * @param object $kitmooicon Icono a actualizar
 * @return bool true si tiene éxito
 */
function kitmoo_update_icon($idicon, $kitmooicon) {
    global $DB;

    $kitmooicon->id = $idicon;

    return $DB->update_record('kitmoo_icon', $kitmooicon);
}

/**
 * Elimina un ícono de una instancia de kitmoo en la Base de Datos
 *
 * @param int $idicon Id del ícono
 */
function kitmoo_delete_icon($idicon) {
    global $DB;

    $DB->delete_records('kitmoo_icon', array('id' => $idicon));
}

/**
 * Busca la sección de una instancia de kitmoo en particular
 *
 * @param int $kitmooid Instancia de kitmoo
 * @return int La sección
 */
function kitmoo_get_section($kitmooid) {
    global $DB;

    // Buscamos la información del módulo kitmoo.
    $kitmoomodule = $DB->get_record('modules', array('name' => 'kitmoo'));

    // Buscamos el curso_módulo.
    $coursemodule = $DB->get_record('course_modules', array('module' => $kitmoomodule->id, 'instance' => $kitmooid));

    // Buscamos la sección de la instancia de kitmoo.
    $coursesection = $DB->get_record('course_sections', array('id' => $coursemodule->section));

    return $coursesection->section;
}

/**
 * Busca el tema que posee una instancia de kitmoo
 *
 * @param int $kitmooid Instancia de kitmoo
 * @return string El tema
 */
function kitmoo_get_theme($kitmooid) {
    global $DB;

    $kitmootheme = $DB->get_record('kitmoo_theme', array('kitmooid' => $kitmooid));

    return $kitmootheme->theme;
}

/**
 * Adiciona el tema de una instancia de kitmoo en la Base de Datos
 *
 * @param int $kitmooid Instancia de kitmoo
 * @param object $kitmootheme Tema a guardar
 */
function kitmoo_insert_theme($kitmooid, $kitmootheme) {
    global $DB;

    $kitmootheme->kitmooid = $kitmooid;

    $DB->insert_record('kitmoo_theme', $kitmootheme, false);
}

/**
 * Actualiza el tema de una instancia de kitmoo en la Base de Datos
 *
 * @param int $kitmooid Instancia de kitmoo
 * @param object $kitmootheme Tema a actualizar
 * @return bool true si tiene éxito
 */
function kitmoo_update_theme($kitmooid, $kitmootheme) {
    global $DB;

    $theme = $DB->get_record('kitmoo_theme', array('kitmooid' => $kitmooid));

    $kitmootheme->id = $theme->id;

    return $DB->update_record('kitmoo_theme', $kitmootheme);
}

/**
 * Crea el entorno gráfico en el curso
 *
 * @param int $kitmooid Instancia de kitmoo
 */
function kitmoo_create_environments($kitmooid) {
    global $DB;
    global $CFG;

    // Buscamos la información del módulo kitmoo.
    $kitmoomodule = $DB->get_record('modules', array('name' => 'kitmoo'));

    // Buscamos el curso_módulo.
    $coursemodule = $DB->get_record('course_modules', array('module' => $kitmoomodule->id, 'instance' => $kitmooid));

    // Creamos el código HTML del entorno creado.
    $html = '';
    $html .= '<p>' . get_string('info', 'kitmoo') . '</p>';

    $kitmootheme = kitmoo_get_theme($kitmooid);
    if (!$kitmootheme) {
        $kitmootheme = 'pix/default.gif';
    }

    $html .= '<div id="container" style="background:url(' . $CFG->wwwroot . '/mod/kitmoo/' . $kitmootheme . ');">';

    if ($kitmoosicons = kitmoo_get_icons($kitmooid)) {
        foreach ($kitmoosicons as $kitmooicon) {
            $html .= '<div class="icon" style="top:' . $kitmooicon->positiontop . ';left:' . $kitmooicon->positionleft . ';">';
            $html .= '<a href="' . $kitmooicon->url . '" title="' . get_string('advice', 'kitmoo') . '">';
            $html .= '<img src="' . $CFG->wwwroot . '/mod/kitmoo/' . $kitmooicon->source . '" alt="[' . $kitmooicon->type . ']" height="64" width="64" />';
            $html .= '</a>';
            $html .= '</div>';
        }
    }

    $html .= '</div>';

    // Agregamos el código HTML en la Base de Datos.
    $record = new stdClass();
    $record->id = $coursemodule->section;
    $record->summary = $html;
    $DB->update_record('course_sections', $record);
}
