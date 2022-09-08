<?php

namespace Classes;

use \PDO;
use \DateTime;


class Display
{

  public function CreateCardEvent($result, $search = false ,$title = false, $year = false)
  {

    $html = "";

    if ($result->rowCount() == 0) {
      if ($search) {
        $html .= '<div class="col-md-12 text-center my-5 text-white">There are no events on your search result.</div>';
      } else {
        $html .= '<div class="col-md-12 text-center my-5 text-white">There are no upcoming events at this time</div>';
      }
    }else {

    $html .= "<section id='events'>
    <div class='container col-10 col-md-7'>";
    if($title == true){
      $html .= "<h4 class='text-center'>Events</h4>";
    }else{
      $html .= "<h4 class='text-center'>This week Events</h4>";
    }
    if($year == true){
      $html .= "<h5>2022</h5>";
    }
     $html .= "<div class='row mt-4'>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

      $start = new DateTime($row['Start_at']);
      $end = new DateTime($row['End_at']);

      $html .= "<div class='col-md-12'>
          <div class='event-item'>
            <div class='event-img'>
              <img src='assets/img/blog/{$row['Image']}' alt=''>
              <div class='event-date'>
                <p>{$start->format('M')}</p>
                <h3>{$start->format('d')}</h3>
              </div>
            </div>
            <div class='event-info'>
              <h6>{$row['Title']}</h6>
              <span class='badge badge-dark'><i class='fa fa-map-marker'></i> {$row['street']} {$row['housenumber']}, {$row['zipcode']} {$row['location']}</span>
              <span class='badge badge-dark'><i class='fa fa-clock'></i> {$start->format('H:m A')} - {$end->format('H:m A')}</span>
            </div>
            <div class='event-ticket'>";
                if($start->format('Y-m-d') >= date('Y-m-d')){
                  $html .= "<a class='event-button' onclick='toastr.warning(\"Soon available\")'>";
                }else{
                  $html .= "<a class='event-button' onclick='toastr.warning(\"Not available\")'>";
                }
              
                $html .= "<i class='fa fa-cart-shopping'></i>
              </a>
            </div>
          </div>
        </div>";
    }

    $html .= "
      </div>
    </div>
  </section>";
  }
    return $html;
  }

  public function CreateTable($result, $edit = false, $delete = false, $read = false, $tablename)
  {
    //        die(var_dump($actionMode));

    $tableheader = false;
    $html = "";
    $html .= "<div class='table-responsive'>";
    $html .= "<table id='{$tablename}' class='table table-striped'>";


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

      if ($tableheader == false) {
        $html .= "<tr>";
        foreach ($row as $key => $value) {
          $html .= "<th>{$key}</th>";
        }
        if ($edit == true || $delete == true || $read == true) {
          $html .= "<th>Actions</th>";
        }
        $html .= "</tr>";
        $tableheader = true;
      }
      $html .= "<tr>";
      foreach ($row as $value) {
        $html .= "<td>" . (empty($value) ? '<i class="fa fa-ban" aria-hidden="true"></i>' : $value) . "</td>";
      }
      if ($edit == true || $delete == true || $read == true) {
        $html .= "<td style='display: flex; justify-content: space-between;'>";
        if ($edit == true) {
          $html .= "<button type='button' id='editbtn' class='btn btn-info editbtn'><i class='fa fa-edit'></i></button>";
        }
        if ($delete == true) {
          $html .= "<button type='button' class='btn btn-danger deletebtn'><i class='fa fa-trash'></i></button>";
        }
        if ($read == true) {
          $html .= "<button type='button' class='btn btn-success viewbtn' onclick=window.location.href='../blog/{$row['id']}'><i class='fa fa-eye'></i></button>";
        }
        $html .= "</td>";
      }
      $html .= "</tr>";
    }
    $html .= "</table>";
    $html .= "</div>";
    return $html;
  }

  public function createBlogCard($result, $search = false, $url = "")
  {
    $html = "";
    $html .= '<div class="row row-cols-1 row-cols-md-2 px-4">';

    if ($result[0]->rowCount() == 0) {
      if ($search) {
        $html .= '<div class="col-md-12 text-center my-5 text-white">There are no blog posts matching your search query.</div>';
      } else {
        $html .= '<div class="col-md-12 text-center my-5 text-white">No blog posts have been found.</div>';
      }
    } else {
      while ($row = $result[0]->fetch(PDO::FETCH_ASSOC)) {
        //Checking if we have the image file localy, else use placeholder.
        $path = 'assets/img/blog/' . $row['thumbnail'];
        $image = file_exists($path) && !empty($row['thumbnail']) ? $path : 'https://via.placeholder.com/280x100';

        $date = new DateTime($row['created_at']);

        //Stripping html of content and checking if it ain't longer than 100 characters
        $content = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($row['content']))))));
        $content = strlen($content) > 100 ? substr($content, 0, 100) . "..." : $content;

        $html .= '<div class="col mb-4 ">';
        $html .= '<div class="card h-100">';
        $html .= '<img  src="' . $image . '" class="card-img-top" alt="blog picture">';
        $html .= '<div class="card-body">
                        <h5 class="card-title text-dark">' . $row['title'] . '</h5>
                        <p class="card-text">' . $content . '</p>
                        <p class="card-text mb-5"><small class="text-muted">' . $date->format('l, d F Y') . '</small></p>
                        <a class="btn btn-secondary btn-sm link" href="' . $url . '/' . $row['id'] . '" role="button">Read more</a>
                    </div>';
        $html .= '</div>';
        $html .= '</div>';
      }
    }

    $html .= '</div>';

    if ($result[1]) {
      if ($result[1] > 1) {
        $html .= '<nav aria-label="pagination">';
        $html .= '<ul class="pagination">';
        for ($i = 1; $i <= $result[1]; $i++) {
          $html .= '<li class="page-item ' . (!empty($_GET['page']) && $_GET['page'] == $i  ? 'active' : (!isset($_GET['page']) && $i == 1 ? 'active' : null)) . '"><a class="page-link" href="' . $url . '?page=' . $i . '">' . $i . '</a></li>';
        }
        $html .= '</ul>';
        $html .= '</nav>';
      }
    }
    return $html;
  }

  public function createSettingsTable($user) {

    if (empty($user['firstname'])) {
      $firstname = "";
    } else {
      $firstname = $user['firstname'];
    }

    if (empty($user['lastname'])) {
      $lastname = "";
    } else {
      $lastname = $user['lastname'];
    }

    $html = '';
    $html .= '<div class="settingsDetailsTitle"><h5>Current Account Details</h5></div>';
    $html .= '<div class="userSettingsTable-Container">';
    $html .= '<form method="post">';
    $html .= '<div class="form-row form-space-between">';
    $html .= '<div class="col-4 col-left">';
    $html .= '<input type="text" name="username" class="form-control form-color-text" placeholder="username" value=' .  $user['username'] . ' required>';
    $html .= '</div>';
    $html .= '<div class="col-4 col-right">';
    $html .= '<input type="email" name="email" class="form-control form-color-text" placeholder="email" value=' .  $user['email'] . ' required>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="form-row form-space-between">';
    $html .= '<div class="col-4 col-left">';
    $html .= '<input type="text" name="firstname" class="form-control form-color-text" placeholder="firstname" value="' .  $firstname . '">';
    $html .= '</div>';
    $html .= '<div class="col-4 col-right">';
    $html .= '<input type="text" name="lastname" class="form-control form-color-text" placeholder="lastname" value="' .  $lastname . '">';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<button type="submit" class="btn btn-primary action-buttons update-action-button">Update Account</button>';
    $html .= "<td><input type='button' href='#passwordResetModal' data-dismiss='modal' data-toggle='modal' class='btn btn-danger action-buttons' value='Password Change?'></input></td>";
    $html .= '</form>';
    $html .= '</div>';

    return $html;
  }

  public function PageNavigation($pages, $page)
  {



    $html = "";
    if ($pages != 0 AND $pages != 1) {
      $html .= "<nav class='mt-4'>";

      $prevArrow = $page;
      $nextArrow = $page;
      $nextArrow++;
      if ($nextArrow > $pages) {
        $nextArrow = $pages;
      }

      $prevArrow--;
      if ($prevArrow <= 0) {
        $prevArrow = 1;
      }


      $html .= "<ul class='pagination'>";
      $html .= '<li class="link page-item"><a class="page-link" href="?number=' . $prevArrow . '"> &laquo; </a></li>';
      for ($x = 1; $x <= $pages; $x++) {
        if ($page == $x) {

          $html .= '<li class="link page-item active"><a class="page-link" href="?number=' . $x . '">' . $x . '<span class="sr-only">(current)</span></a></li>';
        } else {

          $html .= '<li class="link page-item"><a class="page-link" href="?number=' . $x . '">' . $x . '</a></li>';
        }
      }
      $html .=  '<li class="link page-item"><a class="page-link" href="?number=' . $nextArrow . '"> &raquo; </a></li>';
      $html .= "</ul>";
      $html .= "</nav>";
    }

    return $html;
  }
}
