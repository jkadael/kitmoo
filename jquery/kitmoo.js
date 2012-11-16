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
 * JavaScript del Módulo de Actividad Kitmoo
 *
 * @package    mod
 * @subpackage kitmoo
 * @copyright  2012 Jair Riaño, Andrés Rodríguez
 * @copyright  2012 DHumATIC - Universidad de los Llanos <http://www.unillanos.edu.co/>
 * @author     Jair Riaño <jkadael@gmail.com>
 * @author     Andrés Rodríguez <kiddavid180@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function mod_kitmoo() {
    this.version = '1.0';
}

/**
 * Hacer que los elementos div.accordion img se puedan arrastrar
 */
mod_kitmoo.prototype.drag = function() {
    var $drag = $('div.accordion img');

    $drag.draggable( { appendTo: 'body', containment: '#main', cursor: 'move', helper: 'clone', revert: 'invalid' } );
};

/**
 * Cambia el fondo del elemento div#container cuando se dé doble click en el elemento div.theme img
 *
 * Este método llama por medio de AJAX al archivo kitmoo_save.php para guardar el tema seleccionado en la Base de Datos.
 *
 * @param int kitmooid Instancia de kitmoo
 */
mod_kitmoo.prototype.change_background = function(kitmooid) {
    var $change = $('div.theme img');

    // Creamos un evento doble click que cambia el fondo y hace la petición AJAX.
    $change.dblclick(function() {
        var theme = 'pix/' + this.id + '.jpg';

        $('div#container').css( { background: 'url(' + theme + ')' } );
        $.post('kitmoo_save.php', { kitmooid: kitmooid, theme: theme } );
    });
};

/**
 * Hacer que se redireccione a la página de creación de módulos cuando un elemento div.accordion img es arrastrado al elemento div#container
 *
 * @param string root Raíz de la Web
 * @param int course Id del curso
 * @param int section Sección de kitmoo
 * @param int kitmooid Instancia de kitmoo
 * @param string alertone Mensage de alerta
 */
mod_kitmoo.prototype.drop = function(root, course, section, kitmooid, alertone) {
    var $drop = $('div#container');

    $drop.droppable({
        accept: 'div.accordion img',
        drop: function(event, ui) {
            var type = ui.draggable.attr('id');    // Que tipo de módulo va a crear.

            // Confirmamos que desea crear el módulo.
            if (confirm(alertone)) {

                // Si es de tipo Scorm, Chat, Foro, Wiki.
                if (type == 'scorm' || type == 'chat' || type == 'forum' || type == 'wiki') {
                    window.location = root + '/course/kitmoo_modedit.php?add=' + type + '&type=&course=' + course + '&section=' + section + '&return=0&k=' + kitmooid;
                }

                // Si es de tipo Resource, URL, Page.
                if (type == 'resource' || type == 'url' || type == 'page') {
                    window.location = root + '/course/kitmoo_modedit.php?add=' + type + '&type=&course=' + course + '&section=' + section + '&return=0&k=' + kitmooid;
                }
            }
        }
    });
};

/**
 * Configura los íconos que están en el elemento div#container para que puedan ser arrastrados y eliminados
 *
 * Este método llama por medio de AJAX al archivo kitmoo_save.php para guardar la posición actual o eliminar un ícono de la Base de Datos.
 *
 * @param string alerttwo Mensage de alerta
 */
mod_kitmoo.prototype.config_icon = function(alerttwo) {
    // Hacemos que los íconos sean arrastrables.
    $('div.edit_icon').draggable({
        containment: 'div#container',
        cursor: 'move',
        handle: '.anchor',
        drag: function(event, ui) {
            newposition = ui.position;
        },
        stop: function(event, ui) {
            var idicon = $(this).find('.anchor').attr('id');
            $.post('kitmoo_save.php', { idicon: idicon, top: newposition.top, left: newposition.left } );
        }
    });

    // Creamos un evento click sobre la imagen icon_delete.png para eliminar el elemento especificado del contenedor.
    $('img.delete').click(function() {
        var idicon = $(this).parent().find('.anchor').attr('id');

        // Confirmamos que desea eliminar el ícono.
        if (confirm(alerttwo)) {
            $(this).parent().remove();
            $.post('kitmoo_save.php', { idicon: idicon } );
        }
    });
};

/**
 * Realiza un widget de carrusel sobre el elemento #carousel_ul
 */
mod_kitmoo.prototype.carousel = function() {
    $('#carousel_ul li.carousel_item:first').before($('#carousel_ul li.carousel_item:last'));
    var item_width = $('#carousel_ul li.carousel_item').outerWidth();
    var left_indent = parseInt($('#carousel_ul').css('left')) - item_width;

    // Creamos un evento click sobre el elemento .left_menu h2 que movera el carrusel.
    $('.left_menu h2').click(function() {

        $('#carousel_ul li.carousel_item:last').after($('#carousel_ul li.carousel_item:first'));
        $('#carousel_ul').css( { 'left' : '0' } );
    });
};