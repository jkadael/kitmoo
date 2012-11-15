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
 * Página de la herramienta Kitmoo para crear la interfaz gráfica
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

// Obtener parámetros requeridos.
$id = required_param('id', PARAM_INT);

// Obtenemos los datos necesarios a partir de los parámetros requeridos.
if (!$kitmoo = $DB->get_record('kitmoo', array('id' => $id))) {
    print_error('invalidid', 'kitmoo');
}

if (!$course = $DB->get_record('course', array('id' => $kitmoo->course))) {
    print_error('coursemisconf');
}

if (!$cm = get_coursemodule_from_instance('kitmoo', $kitmoo->id, $course->id)) {
    print_error('invalidcoursemodule');
}

// Login requerido para el acceso a esta página.
require_login($course->id, false, $cm);

// Obtenemos el contexto de la instancia.
$context = get_context_instance(CONTEXT_MODULE, $cm->id);

// Configuramos la página.
$PAGE->set_url('/mod/kitmoo/create.php', array('id' => $kitmoo->id));
$PAGE->set_context($context);

// Obtenemos los íconos que posee la instancia de kitmoo.
$kitmoosicons = kitmoo_get_icons($kitmoo->id);

// Obtenemos el tema que posee la instancia de kitmoo.
$kitmootheme = kitmoo_get_theme($kitmoo->id);

// Obtenemos la sección en la que está la instancia de kitmoo.
$kitmoosection = kitmoo_get_section($kitmoo->id);

// Conocer que puede hacer el usuario en el módulo.
$iscreate = has_capability('mod/kitmoo:create', $context);

if ($iscreate) {
?>
<!DOCTYPE html>
<html lang="<?php echo get_string('language', 'kitmoo');?>">
<head>
    <meta charset="utf-8">
    <title><?php echo get_string('title', 'kitmoo');?></title>
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="pix/favicon.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        html,
        body {
            font: 16px Helvetica, Arial, Verdana, sans-serif;
        }
    </style>
</head>
<body>
    <div id="flexible">
    <header id="logo">
        <h1>KITMOO</h1>
        <span><?php echo get_string('version', 'kitmoo');?></span>
    </header>
    <section id="secondary_header">
        <div class="header_tools">
            <h2><?php echo get_string('tools', 'kitmoo');?></h2>
        </div>
        <div class="header_page">
            <h2><?php echo get_string('editpage', 'kitmoo');?></h2>
        </div>
    </section>
    <section id="main">
        <aside class="tools">
            <p><?php echo get_string('message', 'kitmoo');?></p>
            <hr />
            <div class="accordion">
                <ul>
                    <li>
                        <h2><?php echo get_string('resources', 'kitmoo');?></h2>
                        <ul>
                            <li>
                                <img src="pix/resource.png" alt="[<?php echo get_string('file', 'kitmoo');?>]" id="resource" height="45" width="45" />
                                <span><?php echo get_string('file', 'kitmoo');?></span>
                                <div class="tooltip">
                                    <b></b>
                                    <?php echo get_string('descriptionfile', 'kitmoo');?>
                                </div>
                            </li>
                            <li>
                                <img src="pix/url.png" alt="[<?php echo get_string('url', 'kitmoo');?>]" id="url" height="45" width="45" />
                                <span><?php echo get_string('url', 'kitmoo');?></span>
                                <div class="tooltip">
                                    <b></b>
                                    <?php echo get_string('descriptionurl', 'kitmoo');?>
                                </div>
                            </li>
                            <li>
                                <img src="pix/page.png" alt="[<?php echo get_string('page', 'kitmoo');?>]" id="page" height="45" width="45" />
                                <span><?php echo get_string('page', 'kitmoo');?></span>
                                <div class="tooltip">
                                    <b></b>
                                    <?php echo get_string('descriptionpage', 'kitmoo');?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <h2><?php echo get_string('activities', 'kitmoo');?></h2>
                        <ul>
                            <li>
                                <img src="pix/forum.png" alt="[<?php echo get_string('forum', 'kitmoo');?>]" id="forum" height="45" width="45" />
                                <span><?php echo get_string('forum', 'kitmoo');?></span>
                                <div class="tooltip">
                                    <b></b>
                                    <?php echo get_string('descriptionforum', 'kitmoo');?>
                                </div>
                            </li>
                            <li>
                                <img src="pix/chat.png" alt="[<?php echo get_string('chat', 'kitmoo');?>]" id="chat" height="45" width="45" />
                                <span><?php echo get_string('chat', 'kitmoo');?></span>
                                <div class="tooltip">
                                    <b></b>
                                    <?php echo get_string('descriptionchat', 'kitmoo');?> 
                                </div>
                            </li>
                            <li>
                                <img src="pix/scorm.png" alt="[<?php echo get_string('scorm', 'kitmoo');?>]" id="scorm" height="45" width="45" />
                                <span><?php echo get_string('scorm', 'kitmoo');?></span>
                                <div class="tooltip">
                                    <b></b>
                                    <?php echo get_string('descriptionscorm', 'kitmoo');?>
                                </div>
                            </li>
                            <li>
                                <img src="pix/wiki.png" alt="[<?php echo get_string('wiki', 'kitmoo');?>]" id="wiki" height="45" width="45" />
                                <span><?php echo get_string('wiki', 'kitmoo');?></span>
                                <div class="tooltip">
                                    <b></b>
                                    <?php echo get_string('descriptionwiki', 'kitmoo');?>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
        <article id="page">
                <?php
                if (!$kitmootheme) {
                    $kitmootheme = 'pix/default.gif';
                }

                echo '<div id="container" style="background:url(' . $kitmootheme . ');">';

                if ($kitmoosicons) {
                    foreach ($kitmoosicons as $kitmooicon) {
                        echo '<div class="edit_icon" style="top:' . $kitmooicon->positiontop . ';left:' . $kitmooicon->positionleft . ';">';
                        echo '<img src="pix/icon_delete.png" alt="[X]" class="delete" height="16" width="16" />';
                        echo '<img src="' . $kitmooicon->source . '" alt="[' . $kitmooicon->type . ']" id="' . $kitmooicon->id. '" class="anchor" height="64" width="64" />';
                        echo '</div>';
                    }
                }

                echo '</div>';
                ?>
        </article>
    </section>
    <section id="menu">
        <div class="left_menu">
            <h2><?php echo get_string('theme', 'kitmoo');?></h2>
        </div>
        <div id="carousel_inner">
            <ul id="carousel_ul">
                <li class="carousel_item">
                    <div class="center_menu">
                        <div class="theme">
                            <ul>
                                <li>
                                    <img src="pix/theme1.jpg" alt="[<?php echo get_string('themeone', 'kitmoo');?> 1]" id="theme1" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme2.jpg" alt="[<?php echo get_string('themeone', 'kitmoo');?> 2]" id="theme2" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme3.jpg" alt="[<?php echo get_string('themeone', 'kitmoo');?> 3]" id="theme3" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme4.jpg" alt="[<?php echo get_string('themeone', 'kitmoo');?> 4]" id="theme4" height="45" width="45" />
                                </li>
                            </ul>
                        </div>
                        <span><?php echo get_string('themeone', 'kitmoo');?></span>
                    </div>
                    <div class="right_menu">
                        <div class="theme">
                            <ul>
                                <li>
                                    <img src="pix/theme5.jpg" alt="[<?php echo get_string('themetwo', 'kitmoo');?> 5]" id="theme5" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme6.jpg" alt="[<?php echo get_string('themetwo', 'kitmoo');?> 6]" id="theme6" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme7.jpg" alt="[<?php echo get_string('themetwo', 'kitmoo');?> 7]" id="theme7" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme8.jpg" alt="[<?php echo get_string('themetwo', 'kitmoo');?> 8]" id="theme8" height="45" width="45" />
                                </li>
                            </ul>
                        </div>
                        <span><?php echo get_string('themetwo', 'kitmoo');?></span>
                    </div>
                </li>
                <li class="carousel_item">
                    <div class="center_menu">
                        <div class="theme">
                            <ul>
                                <li>
                                    <img src="pix/theme9.jpg" alt="[<?php echo get_string('themethree', 'kitmoo');?> 9]" id="theme9" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme10.jpg" alt="[<?php echo get_string('themethree', 'kitmoo');?> 10]" id="theme10" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme11.jpg" alt="[<?php echo get_string('themethree', 'kitmoo');?> 11]" id="theme11" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme12.jpg" alt="[<?php echo get_string('themethree', 'kitmoo');?> 12]" id="theme12" height="45" width="45" />
                                </li>
                            </ul>
                        </div>
                        <span><?php echo get_string('themethree', 'kitmoo');?></span>
                    </div>
                    <div class="right_menu">
                        <div class="theme">
                            <ul>
                                <li>
                                    <img src="pix/theme13.jpg" alt="[<?php echo get_string('themefour', 'kitmoo');?> 13]" id="theme13" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme14.jpg" alt="[<?php echo get_string('themefour', 'kitmoo');?> 14]" id="theme14" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme15.jpg" alt="[<?php echo get_string('themefour', 'kitmoo');?> 15]" id="theme15" height="45" width="45" />
                                </li>
                                <li>
                                    <img src="pix/theme16.jpg" alt="[<?php echo get_string('themefour', 'kitmoo');?> 16]" id="theme16" height="45" width="45" />
                                </li>
                            </ul>
                        </div>
                        <span><?php echo get_string('themefour', 'kitmoo');?></span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <footer id="notice">
        <div class="info">
            <small>KITMOO, Version 1.0 - GNU General Public License.</small>
        </div>
        <div class="accept">
            <form action="<?php echo $CFG->wwwroot . '/mod/kitmoo/kitmoo_save.php';?>" method="post">
                <input type="hidden" name="kitmooid" value="<?php echo $kitmoo->id;?>" />
                <input type="hidden" name="course" value="<?php echo $course->id;?>" />
                <input type="submit" name="ready" value="<?php echo get_string('ready', 'kitmoo');?>" />
            </form>
        </div>
    </footer>
    <script src="jquery/jquery-1.7.2.min.js"></script>
    <script src="jquery/jquery-ui-1.8.21.custom.min.js"></script>
    <script src="jquery/kitmoo.js"></script>
    <script>
        var section = <?php echo $kitmoosection;?>;
        var root = '<?php echo $CFG->wwwroot;?>';
        var course = <?php echo $course->id;?>;
        var kitmooid = <?php echo $kitmoo->id;?>;
        var alertone = "<?php echo get_string('alertone', 'kitmoo');?>";
        var alerttwo = "<?php echo get_string('alerttwo', 'kitmoo');?>";

        $(document).ready(function() {
            var instance = new mod_kitmoo();

            instance.drag();
            instance.change_background(kitmooid);
            instance.drop(root, course, section, kitmooid, alertone);
            instance.config_icon(alerttwo);
            instance.carousel();
        });
    </script>
    </div>
</body>
</html>
<?php
} else {
    redirect("$CFG->wwwroot/course/view.php?id=$course->id");    // Redireccionamos al curso.
    exit;
}
?>