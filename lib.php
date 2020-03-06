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
 * Serve question type files
 *
 * @since      2.0
 * @package    qtype
 * @subpackage drawing
 * @copyright  ETHZ LET <amr.hourani@id.ethz.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Checks file access for drawing questions.
 */
function qtype_drawing_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG;//echo "ffff";exit;
    require_once($CFG->libdir . '/questionlib.php');

    $itemid = array_shift($args); // The first item in the $args array.

  // Use the itemid to retrieve any relevant data records and perform any security checks to see if the
  // user really does have access to the file in question.

  // Extract the filename / filepath from the $args array.
  $filename = array_pop($args); // The last item in the $args array.
  if (!$args) {
      $filepath = '/'; // $args is empty => the path is '/'
  } else {
      $filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
  }

  // Retrieve the file from the Files API.
  $fs = get_file_storage();
  $file = $fs->get_file($context->id, 'qtype_drawing', $filearea, $itemid, $filepath, $filename);
  if (!$file) {
      return false; // The file does not exist.
  }

  // We can now send the file back to the browser - in this case with a cache lifetime of 1 day and no filtering.
  send_stored_file($file, 86400, 0, $forcedownload, $options);

//    question_pluginfile($course, $context, 'qtype_drawing', $filearea, $args, $forcedownload, $options);
}