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
 * Define las capacidades/permisos del Módulo de Actividad Kitmoo
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

// Especificamos los permisos.
$capabilities = array(

    'mod/kitmoo:view' => array(    // Nombre capacidad/permiso.

        'captype' => 'read',    // Tipo de capacidad.
        'contextlevel' => CONTEXT_MODULE,    // Contexto de la capacidad.
        'archetypes' => array(    // Roles.
            'teacher' => CAP_ALLOW,
            'student' => CAP_ALLOW,
            'guest' => CAP_ALLOW,
            'coursecreator' => CAP_ALLOW,
            'user' => CAP_ALLOW,
            'frontpage' => CAP_ALLOW
        )
    ),

    'mod/kitmoo:create' => array(    // Nombre capacidad/permiso.

        'captype' => 'write',    // Tipo de capacidad.
        'contextlevel' => CONTEXT_MODULE,    // Contexto de la capacidad.
        'archetypes' => array(    // Roles.
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW
        )
    )
);
