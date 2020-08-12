<?php

namespace Drupal\course_result\Commands;

use Drupal\user\Entity\User;
use Drush\Commands\DrushCommands;
use Drupal\Core\StreamWrapper\PublicStream;

class CourseResultExportCVS extends DrushCommands {

  /**
   * Drush command that displays the given text.
   *
   * @param string $startDate
   *   Argument start date to search from.
   * @param string $endDate
   *   Argument end date to search from.
   * @param string $filename
   *   File name.
   * @command course_result_export:message
   * @aliases course_result_export cre
   * @option export
   *   Export course result.
   * @usage course_result_export:message startDate endDate
   */
  public function message($startDate = '', $endDate = '' , $filename = 'course_result') {

    $startDate = $this->formatTimeToTimestamp($startDate);
    $endDate = $this->formatTimeToTimestamp($endDate);
    $query = \Drupal::entityTypeManager()->getStorage('course_result')->getQuery();
    $nids = $query->condition('changed', [ $startDate, $endDate ],'BETWEEN')->execute();
    $results = \Drupal::entityTypeManager()->getStorage('course_result')->loadMultiple($nids);

    if(!empty($results)) {
      $this->saveToCSV($results, $filename);
    }
    $this->output()->writeln('Fail on kättesaadav järgneval lingil');
    $this->output()->writeln(\Drupal::request()->getHost().'/'.PublicStream::basePath().'/'.$filename.'.csv');
  }

  public function formatTimeToTimestamp($time) {

    $haystackDelimiters = [ '.','/',':' ];
    foreach ($haystackDelimiters as $delimiter) {
      if(strpos($time, $delimiter)){
        return $time = strtotime(join("-",(explode($delimiter,$time))));
      }
    }
    return $time;
  }

  public function saveToCSV($array, $filename) {

    $fp = fopen('public://'.$filename.'.csv', 'w');
    fputcsv($fp, [
      'user Email',
      'Score A',
      'score B',
    ]);
    foreach ($array as $result ){
      $userEmail = User::load($result->course_participant_uid->getString())->mail->value;

      if(empty($userEmail)){
        $userEmail = 'no email';
      }

      fputcsv($fp,[
        $userEmail,
        $result->score_a->getString(),
        $result->score_b->getString(),
      ]);
    }
    fclose($fp);
  }
}