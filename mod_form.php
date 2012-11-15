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
 * Formulario de configuración príncipal del Módulo de Actividad Kitmoo
 *
 * @package    mod
 * @subpackage kitmoo
 * @copyright  2012 Jair Riaño, Andrés Rodríguez
 * @copyright  2012 DHumATIC - Universidad de los Llanos <http://www.unillanos.edu.co/>
 * @author     Jair Riaño <jkadael@gmail.com>
 * @author     Andrés Rodríguez <kiddavid180@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Saber si se ha incluido desde una página de Moodle.
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

// Incluir clase padre de gestión de formularios.
require_once($CFG->dirroot . '/course/moodleform_mod.php');

class mod_kitmoo_mod_form extends moodleform_mod {

    /**
     * Definir los elementos del formulario
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        // Adicionar un fieldset de nombre "general" donde todas las configuraciones comunes se muestran.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adicionar el campo estándar "name".
        $mform->addElement('text', 'name', get_string('kitmooname', 'kitmoo'), array('size' => '64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }

        // Adicionar regla de validación al campo anterior (campo requerido).
        $mform->addRule('name', null, 'required', null, 'client');

        // Adicionar el campo estándar "intro" e "introformat".
        $this->add_intro_editor(true, get_string('kitmoointro', 'kitmoo'));

        // Adicionar elementos comunes de todos los módulos.
        $this->standard_coursemodule_elements();

        // Adicionar botones (botón enviar y cancelar) comunes de todos los módulos.
        $this->add_action_buttons();
    }
}
