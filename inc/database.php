<?php
session_start();
include('config/connect.php');
class cart {
    public $id, $name, $image, $price, $quantity;
    function __construct($id, $name, $image, $price, $quantity) {
      $this->id = $id;
      $this->name = $name;
      $this->image = $image;
      $this->price = $price;
      $this->quantity = $quantity;

    }
}
 function _header($title) {
    $s = '
    <!DOCTYPE html>
      <html lang="en">
       <head>
          <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>'.$title.'</title>
              <link rel="icon" type="image/x-icon" href="icons/favicon.ico">
              <link rel="apple-touch-icon" sizes="180x180" href="icons/apple-touch-icon.png">
             <link rel="icon" type="image/png" sizes="32x32" href="icons/favicon-32x32.png">
             <link rel="icon" type="image/png" sizes="16x16" href="icons/favicon-16x16.png">
            <link rel="manifest" href="icons/site.webmanifest">
            <!-- Google Font -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
           <link href="https://fonts.googleapis.com/css2?family=Faculty+Glyphic&family=Host+Grotesk:ital,wght@0,300..800;1,300..800&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
            <!-- Css Styles -->
            <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
            <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
             <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
            <link rel="stylesheet" href="css/nice-select.css" type="text/css">
            <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
            <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
            <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
            <link rel="stylesheet" href="https://enbesu.vn/css/style.css" type="text/css">
            <link rel="stylesheet" href="boottrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
            <script src="boottrap/js/bootstrap.bundle.js"></script>
            <script src="boottrap/js/bootstrap.min.js"></script>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
         </head>
        <body>
    ';
    echo $s;
  }

function _footer() {
    $s = '
        <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="https://enbesu.vn/"><img src="icons/logo.png" width="50%" alt=""></a>
                        </div>
                        <ul>
                            <li>Số Điện Thoại: 0368929395</li>
                            <li>Email:  hotro.enbesu@gmail.com</li>
                            <li>CN ĐKKD Số : 40A8032106</li>
                            <li>CN ĐK ATTP Số : 12/2022/NNPTNT-ĐL</li>
                            <li>NSX : Thôn 3, Hoà Phú, Buôn Ma Thuột, Đắk Lắk</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>Về chúng tôi</h6>
                        <ul>
                            <li><a href="https://enbesu.vn/">Trang Chủ</a></li>
                            <li><a href="index.php#baiviet">Bài viết</a></li>
                            <li><a href="tintuc.php">Tin tức</a></li>
                            <li><a href="gioithieu.php">Giới thiệu</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>Hỗ trợ khách hàng</h6>
                        <ul>
                            <li><a href="thanhvien.php">Chính sách thẻ thành viên</a></li>
                            <li><a href="https://enbesu.vn/">Chính sách đổi trả</a></li>
                            <li><a href="https://enbesu.vn/">Hướng dẫn mua hàng</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>Liên Hệ</h6>';
                        
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["gui"])) {
                            if (isset($_POST["email"]) && isset($_POST["message"])) {
                                $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
                                $message = htmlspecialchars($_POST["message"]);
                                
                                if (!$email) {
                                    echo "<script>alert('Email không hợp lệ!');</script>";
                                } else {
                                    $email = Database::getConnection()->real_escape_string($email);
                                    $message = Database::getConnection()->real_escape_string($message);
                                    $sql = "INSERT INTO contacts (email, message) VALUES ('$email', '$message')";
                                    if (Database::query($sql) === TRUE) {
                                        echo "<script>alert('Liên hệ đã gửi thành công!');</script>";
                                    } else {
                                        echo "<script>alert('Lỗi: " . Database::getConnection()->error . "');</script>";
                                    }
                                }
                            } else {
                                echo "<script>alert('Vui lòng điền đầy đủ thông tin.');</script>";
                            }
                        }
                        
                        $s .= '<form action="" method="POST">
                        <input type="email" name="email" placeholder="Email của bạn" required>
                        <textarea name="message" placeholder="Tin nhắn của bạn" required></textarea>
                        <button type="submit" name="gui" class="site" style="height: 90px;">Gửi</button>
                    </form>';             
                    $s .= '</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p>
                               &copy;
                                Bản quyền thuộc về &nbsp;<a href="https://enbesu.vn/" target="_blank">Enbesu</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </footer>
             <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
                 <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/jquery.slicknav.min.js"></script>
                  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
            <script src="https://enbesu.vn/js/mixitup.min.js"></script>
           <script src="https://enbesu.vn/js/main.js"></script>
        </body>
        </html>
    ';
    echo $s;
}
function _navbar() {
    if(isset($_GET['id_product']))addtoCartProduct($_GET['id_product']);
    if(isset($_GET['clear']))unset($_SESSION['cart']);
    $s = '
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="index.php"><img src="icons/logo.png" width="80px" height="80px" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                  <li><a href="giohang.php"><i class="fa fa-shopping-bag"></i> <span>';
                            if(!isset($_SESSION['cart'])) $s.= '0';
                            else $s.= count($_SESSION['cart']);
                            $s .= '</span></a></li>
            </ul>
           <div class="header__cart__price">Giỏ hàng: <span>';
                        if(!isset($_SESSION['cart'])) $s.= '0';
                        else $s.= count($_SESSION['cart']);
                        $s .= '</span></div>
        </div>
        <div class="humberger__menu__widget">';
                            if(!isset($_SESSION['user'])) 
                                $s .= '<div class="header__top__right__auth">
                                    <a href="dangnhap.php"><i class="fa fa-user"></i>Đăng Nhập</a>
                                </div>';
                            else {
                                $s .= '
                                <div class="header__top__right__auth">
                                    <i class="fa fa-user" aria-hidden="true"></i><p>
                                      Chào &nbsp;'.splitName($_SESSION['user']['name']).'
                                    </p>
                                    <div class="dropdown accessibility-issue--success">
                                    <button class="dropbtn"><i class="fa fa-caret-down"></i></button>
                                    <div class="dropdown-content">
                                        <a href="user.php">Thông tin tài khoản</a>
                                         <a href="order.php">Đơn hàng của tôi</a>
                                        <a href="dangxuat.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a>
                                    </div>
                                </div>
                                </div>';
                            }
    $s .= '      
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="index.php">Trang Chủ</a></li>
                <li><a href="gioithieu.php">Về Chúng tôi</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="gioithieu.php">Giới thiệu</a></li>
                         <li><a href="thanhvien.php">Thẻ thành viên</a></li>
                    </ul>
                </li>
                <li><a href="sanpham.php">Sản Phẩm</a>
                    <ul class="header__menu__dropdown">';
                        $q = Database::query("SELECT * FROM `categories`");
                        while($r = $q->fetch_array()) {
                            $s .= '<li><a href="sanpham.php?id_category='.$r['id'].'">'.$r['name'].'</a></li>';
                        }
    $s .= '</ul>
                </li>
                 <li><a href="lienhe.php">Liên Hệ</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i>hotro.enbesu@gmail.com</li>
                <li><a href="http://zalo.me/0368929395"><img src="assets/images/zalo.png" width="15px" height="15px">&nbsp;Đặng Vinh Quang</a></li>
                <li><a href="tel:0368929395"><i class="fa fa-phone" aria-hidden="true"></i>0368929395</a></li>
            </ul>
            <ul>
             <li>CN ĐKKD Số : 40A8032106</li>
             <li>CN ĐK ATTP Số : 12/2022/NNPTNT-ĐL</li>
            </ul>
        </div>
    </div>
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i>hotro.enbesu@gmail.com</li>
                                <li><a href="http://zalo.me/0368929395"><img src="assets/images/zalo.png" width="25px" height="25px">&nbsp;Đặng Vinh Quang</a></li>
                                <li><a href="tel: 0368929395"><i class="fa fa-phone" aria-hidden="true"></i>0368929395</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                           <div class="header__top__right__social">
                                <a href="mailto:hotro.enbesu@gmail.com"><i class="fa fa-envelope"></i></a>
                            </div>  
                        ';
                        if(!isset($_SESSION['user'])) {
                            $s .= '<div class="header__top__right__auth">
                                        <a href="dangnhap.php"><i class="fa fa-user"></i>Đăng Nhập</a>
                                    </div>';
                        } else {
                            $s .= '
                            <div class="header__top__right__auth">
                                <i class="fa fa-user" aria-hidden="true"></i><p>
                                    Chào &nbsp;'.splitName($_SESSION['user']['name']).'
                                </p>
                                <div class="dropdown accessibility-issue--success">
                                    <button class="dropbtn"><i class="fa fa-caret-down"></i></button>
                                    <div class="dropdown-content">
                                        <a href="user.php">Thông tin tài khoản</a>
                                        <a href="order.php">Đơn hàng của tôi</a>
                                        <a href="dangxuat.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a>
                                    </div>
                                </div>
                            </div>';
                        }
                        
    $s .= '      
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="index.php"><img src="icons/logo.png" alt="" width="80px" height="80px"></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="index.php">Trang Chủ</a></li>
                            <li><a href="gioithieu.php">Về Chúng tôi</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="gioithieu.php">Giới thiệu</a></li>
                                    <li><a href="thanhvien.php">Thẻ thành viên</a></li>
                                </ul>
                            </li>
                            <li><a href="sanpham.php">Sản Phẩm</a>
                                <ul class="header__menu__dropdown">';
                                    $q = Database::query("SELECT * FROM `categories`");
                                    while($r = $q->fetch_array()) {
                                        $s .= '<li><a href="sanpham.php?id_category='.$r['id'].'">'.$r['name'].'</a></li>';
                                    }
    $s .= '</ul>
                            </li>
                            <li><a href="lienhe.php">Liên Hệ</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="giohang.php"><i class="fa fa-shopping-bag"></i> <span>';
                            if(!isset($_SESSION['cart'])) $s.= '0';
                            else $s.= count($_SESSION['cart']);
                            $s .= '</span></a></li>
                        </ul>
                        <div class="header__cart__price">Giỏ hàng: <span>';
                        if(!isset($_SESSION['cart'])) $s.= '0';
                        else $s.= count($_SESSION['cart']);
                        $s .= '</span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    ';
    echo $s;
}
function _body() {
    $s = '';
    if(!isset($_GET['id_category']))
        $q = Database::query("SELECT * FROM `categories`");
    else 
        $q = Database::query("SELECT * FROM `categories` WHERE id=".$_GET['id_category']);
    while($r = $q->fetch_array()) {
     $s .= '<section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>'.$r['name'].'</h2>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">';
            if(!isset($_GET['id_category']))
                $q1 = Database::query("SELECT * FROM `products` WHERE status=true and id_category=".$r['id']);
            else 
                $q1 = Database::query("SELECT * FROM `products` WHERE id_category=".$r['id']);
            while($r1 = $q1->fetch_array()) {
              //if($r['id'] == $r1['id_category'] && $r1['status'] == true)
                $s .= '<div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg">
                           <img src="assets/images/'.$r1['image'].'" alt="" width="100%" height="100%">
                            <ul class="featured__item__pic__hover">
                                <li><a href="';
                                if(!isset($_SESSION['user']))
                                   $s.= 'dangnhap.php';
                                else 
                                   $s.= 'index.php?id_product='.$r1['id'];
                                $s.='"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6>'.$r1['name'].'</h6>
                            <h5>'.$r1['price'].'<span>đ</span></h5>
                        </div>
                    </div>
                </div>';
            }
            $s .='</div>
        </div>
    </section>
    ';
    }
    echo $s;
  }
function _hero() {
    $s = '
      <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span style="font-family: "Lato", serif;">Danh Mục</span>
                        </div>
                        <ul>';
                        $q = Database::query("SELECT * FROM `categories`");
                        while($r = $q->fetch_array()) {
                            $s .= '<li><a href="sanpham.php?id_category='.$r['id'].'"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp;'.$r['name'].'</a></li>';
                        }
                        $s .= '</ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                              <form action="sanpham.php" method="GET">
                                <input type="text" name="search_query" placeholder="Bạn cần tìm kiếm gì?" value="'.(isset($_GET['search_query']) ? $_GET['search_query'] : '').'">
                                <button type="submit" class="site-btn" style="border-radius: 50px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>0368929395</h5>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                    </div>
                   <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                         <div class="carousel-inner">';
                         $q1 = Database::query("SELECT * FROM `banner`");
                         while($r1 = $q1->fetch_array()) {
                            $s .= '<div class="carousel-item active" data-bs-interval="5000">
                             <img src="assets/images/'.$r1['image'].'" class="d-block w-100" alt="...">
                           </div>';
                         }
                        $s .= '</div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Previous</span>
                 </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                 <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
                </div>
            </div>
        </div>
    </section>
    ';
    echo $s;
}
  function _categories() {
    $s = '
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">';
                  $q1 = Database::query("SELECT * FROM `categories_items`");
                  while($r1 = $q1->fetch_array()) {
                    $s .= '<div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="assets/images/'.$r1['image'].'">
                            <h5><a href="#">'.$r1['title'].'</a></h5>
                        </div>
                    </div>'; 
                }
                $s .= '</div>
            </div>
        </div>
    </section>
    ';
    echo $s;
  }
function _blog($titileblog) {
    $s = '
        <section class="from-blog spad" id="baiviet">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>'.$titileblog.'</h2>
                    </div>
                </div>
            </div>
            <div class="row">';
             $q = Database::query("SELECT * FROM `blog`");
             while ($r = $q->fetch_array()) {
                  $s .= '<div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/'. $r['image'].'" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> '.$r['day'].'</li>
                            </ul>
                            <h5><a href="baiviet.php?id_blog=' . intval($r['id']) . '">'.$r['title'].'</a></h5>
                            <p>'.$r['pagaph'].'</p>
                        </div>
                    </div>
                </div>';
            }
    $s .= '</div>
        </div>
    </section>';
    echo $s;
}
function login(){
    if (isset($_POST['emailphone']) && isset($_POST['password'])) {
        if (is_numeric($_POST['emailphone'])) {
            $x = 'phone';
        } else {
            $x = 'email';
        }
        
        $q = Database::query("SELECT * FROM users WHERE $x = '{$_POST['emailphone']}' AND password = '{$_POST['password']}'");
        if ($r = $q->fetch_array()) {
            if ($r['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                $_SESSION['user'] = $r;
                if (isset($_POST['remember_me'])) {
                    setcookie('emailphone', $_POST['emailphone'], time() + (86400 * 30), "/"); 
                    setcookie('password', $_POST['password'], time() + (86400 * 30), "/"); 
                } else {
                    setcookie('emailphone', '', time() - 3600, "/");
                    setcookie('password', '', time() - 3600, "/");
                }
                
                header("Location: index.php");
            }
        } else {
            $_SESSION['login_fail'] = 'Dữ liệu nhập không chính xác!!!';
            header("Location: dangnhap.php");
        }
    }

    $saved_emailphone = isset($_COOKIE['emailphone']) ? $_COOKIE['emailphone'] : '';
    $saved_password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

    $s = '
    <section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">';
        $q = Database::query("SELECT * FROM `dangnhap`");
        while($r = $q->fetch_array()) {
        $s .= '<div class="col-md-9 col-lg-6 col-xl-5">
            <img src="assets/images/'.$r['image'].'"
            class="img-fluid" alt="Sample image">
        </div>';
        }
        $s .= '<div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form action="" method="post">
            <h2 style="padding: 40px 0 25px 0">Đăng Nhập</h2>';
           if (isset($_SESSION['login_fail'])) {
               $s .= '<div style="color: red;">'.$_SESSION['login_fail'].'</div>';
               unset($_SESSION['login_fail']); 
           }
           
            $s .= '<!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" name="emailphone" class="form-control form-control-lg"
                placeholder="Nhập vào số điện thoại của bạn" value="' . htmlspecialchars($saved_emailphone) . '" />
            </div>
            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-3">
                <input type="password" name="password" class="form-control form-control-lg"
                placeholder="Nhập vào mật khẩu" id="password" value="' . htmlspecialchars($saved_password) . '" />
                <button type="button" onclick="togglePassword()" class="btn btn-secondary btn-sm mt-2">Hiện/Ẩn mật khẩu</button>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <!-- Remember Me Checkbox -->
                <div class="form-check mb-0">
                    <input class="form-check-input me-2" type="checkbox" name="remember_me" value="1" id="form2Example3"' . (!empty($saved_emailphone) ? ' checked' : '') . ' />
                    <label class="form-check-label" for="form2Example3">
                        Ghi nhớ mật khẩu    
                    </label>
                </div>
                <a href="#!" class="text-body">Quên mật khẩu?</a>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng Nhập</button>
                <p class="small fw-bold mt-2 pt-1 mb-0">Bạn chưa có tài khoản? <a href="dangky.php"
                    class="link-danger">Đăng ký</a></p>
            </div>
            </form>
        </div>
        </div>
    </div>
    
    </section>

    <script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
    </script>
    ';

    echo $s;
}
 function splitName($str){
        $rs = NULL;
        $word = mb_split(' ', $str);
        $n = count($word)-1;
        if ($n > 0) {$rs = $word[$n];}

        return $rs;
}
function register(){
    $errName = $errPhone = $errPass = $errRepass = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (empty($_POST['name'])) {
            $errName = "Vui lòng nhập vào tên của bạn!";
        }
        if (empty($_POST['phone'])) {
            $errPhone = "Cần có 1 số điện thoại!";
        } else {
            if (!preg_match('/^\d{10}$/', $_POST['phone'])) {
                $errPhone = "Số điện thoại phải có đúng 10 chữ số!";
            } else {
                $phoneCheckQuery = "SELECT COUNT(*) FROM users WHERE phone='" . $_POST['phone'] . "'";
                $phoneCheckResult = Database::query($phoneCheckQuery);
                $phoneExists = $phoneCheckResult->fetch_array()[0];

                if ($phoneExists > 0) {
                    $errPhone = "Số điện thoại đã tồn tại!";
                }
            }
        }
        if (empty($_POST['pass'])) {
            $errPass = "Vui lòng nhập mật khẩu!";
        }
        if (empty($_POST['repass'])) {
            $errRepass = "Vui lòng xác nhận mật khẩu!";
        } else {
            if ($_POST['pass'] != $_POST['repass']) {
                $errRepass = "Mật khẩu không khớp!";
            }
        }
        if ($errName == '' && $errPhone == '' && $errPass == '' && $errRepass == '') {
            $insertQuery = "INSERT INTO users(name, phone, password, role) VALUES('".$_POST['name']."', '".$_POST['phone']."', '".$_POST['pass']."', '')";
            Database::query($insertQuery);
            $userQuery = "SELECT * FROM users WHERE phone='" . $_POST['phone'] . "' AND password='" . $_POST['pass'] . "'";
            $userResult = Database::query($userQuery);
            $_SESSION['user'] = $userResult->fetch_array();
            header("location: index.php");
        }
    }

    $s = '
        <section class="vh-80" style="background-color: #eee; border: none; border-radius: none;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                <div class="card-body p-md-3">
                    <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Đăng Ký</p>

                        <form class="mx-1 mx-md-4" action="" method="post">

                        <div class="d-flex flex-row align-items-center mb-3">
                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example1c">Tên của bạn</label>
                            <input type="text" name="name" class="form-control" />
                            <span style="color: red;">'.$errName.'</span>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center mb-3">
                            <i class="fas fa-phone fa-lg me-3 fa-fw"></i>
                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example3c">Số điện thoại của bạn</label>
                            <input type="text" name="phone" class="form-control" />
                            <span style="color: red;">'.$errPhone.'</span>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-3">
                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example4c">Mật Khẩu</label>
                            <input type="password" id="pass" name="pass" class="form-control" />
                            <span style="color: red;">'.$errPass.'</span>
                            <input type="checkbox" onclick="togglePassword(\'pass\')"> Hiển thị mật khẩu
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-3">
                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example4cd">Xác nhận mật khẩu</label>
                            <input type="password" id="repass" name="repass" class="form-control" />
                            <span style="color: red;">'.$errRepass.'</span>
                            <input type="checkbox" onclick="togglePassword(\'repass\')"> Hiển thị mật khẩu
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg">Đăng ký</button>
                        </div>

                        </form>

                    </div>';
                    $q = Database::query("SELECT * FROM `dangky`");
                    while($r = $q->fetch_array()) {
                    $s .= '<div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                        <img src="assets/images/'.$r['image'].'"
                        class="img-fluid" alt="Sample image">
                    </div>';
                    }
                   $s .= '</div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </section>
        
        <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
            } else {
                field.type = "password";
            }
        }
        </script>
    ';
    echo $s;
}
function _products() {
    $s = '
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Danh Mục</span>
                        </div>
                        <ul>';
                           $categories = Database::getConnection()->query("SELECT * FROM `categories`");
                            while ($category = $categories->fetch_array()) {
                                $s .= '<li><a href="?id_category=' . $category['id'] . '"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>&nbsp; ' . $category['name'] . '</a></li>';
                               }
                            $s .= '</ul>
                          </div>
                        </div>
                    <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="sanpham.php" method="GET">
                                <input type="text" name="search_query" placeholder="Bạn cần tìm kiếm gì?" value="' . (isset($_GET['search_query']) ? $_GET['search_query'] : '') . '">
                                <button type="submit" class="site-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>0368929395</h5>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>';
    if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
        $search_query = Database::getConnection()->real_escape_string(trim($_GET['search_query']));
        $products = Database::getConnection()->query("SELECT * FROM `products` WHERE `name` LIKE '%$search_query%' AND `status` = true");

        $s .= '<section class="featured spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <h2>Kết quả tìm kiếm cho: "'.$search_query.'"</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row featured__filter">';

        if ($products->num_rows > 0) {
            while ($product = $products->fetch_array()) {
                $s .= renderProduct($product);
            }
        } else {
            $s .= '<div class="col-lg-12"><p>Không tìm thấy sản phẩm phù hợp với từ khóa: "'.$search_query.'"</p></div>';
        }
        $s .= '</div></div></section>';
    } elseif (isset($_GET['id_category']) && is_numeric($_GET['id_category'])) {
        $id_category = intval($_GET['id_category']);
        $category_query = Database::getConnection()->query("SELECT * FROM `categories` WHERE `id` = $id_category");
        $category = $category_query->fetch_array();

        $products = Database::getConnection()->query("SELECT * FROM `products` WHERE `status` = true AND `id_category` = $id_category");

        $s .= '<section class="featured spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <h2>'.$category['name'].'</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row featured__filter">';

        if ($products->num_rows > 0) {
            while ($product = $products->fetch_array()) {
                $s .= renderProduct($product);
            }
        } else {
            $s .= '<div class="col-lg-12"><p>Không có sản phẩm nào trong danh mục này.</p></div>';
        }

        $s .= '</div></div></section>';
    } else {
        $categories = Database::getConnection()->query("SELECT * FROM `categories`");

        while ($category = $categories->fetch_array()) {
            $s .= '<section class="featured spad">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title">
                                    <h2>'.$category['name'].'</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row featured__filter">';

            $products = Database::getConnection()->query("SELECT * FROM `products` WHERE `status` = true AND `id_category` = " . $category['id']);
            if ($products->num_rows > 0) {
                while ($product = $products->fetch_array()) {
                    $s .= renderProduct($product);
                }
            } else {
                $s .= '<div class="col-lg-12"><p>Không có sản phẩm nào trong danh mục này.</p></div>';
            }

            $s .= '</div></div></section>';
        }
    }

    echo $s;
}
function renderProduct($product) {
    return '
    <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
        <div class="featured__item">
            <div class="featured__item__pic set-bg">
                <a href="thongtin.php?id_info=' . $product['id'] . '">
                    <img src="assets/images/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" width="100%" height="100%" style="border-radius: 30px;">
                </a>
                <ul class="featured__item__pic__hover">
                    <li><a href="thongtin.php?id_info=' . $product['id'] . '"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                    <li><a href="' . (isset($_SESSION['user']) ? 'sanpham.php?id_product=' . $product['id'] : 'dangnhap.php') . '"><i class="fa fa-shopping-cart"></i></a></li>
                </ul>
            </div>
            <div class="featured__item__text">
                <h6>' . htmlspecialchars($product['name']) . '</h6>
                <h5 style="text-decoration:line-through; font-weight: 500; font-size: 18px; font-family: "Lato", serif;">' . htmlspecialchars($product['price_old']) . '</h5>
                <h5 style="color: red;">' . htmlspecialchars($product['price']) . '<span>đ</span></h5>
            </div>
        </div>
    </div>';
}

function addtoCartProduct($id_product) {
    $q = Database::query("SELECT * FROM `products` WHERE id =". $id_product);
    $r = $q->fetch_array();
    if(isset($_SESSION['cart'])) {
        $a = $_SESSION['cart'];
        for($i = 0; $i <count($a); $i++) 
            if($r['id']==$a[$i]->id)break;
        if($i<count($a))$a[$i]->quantity++;
        else  $a[count($a)] = new cart($r['id'], $r['name'], $r['image'], $r['price'], 1);
        
    }else {
        $a = array();
        $a[0] = new cart($r['id'], $r['name'], $r['image'], $r['price'], 1);
    }
    $_SESSION['cart'] = $a;
}

function cart() {
    $total = 0;
    // Xóa sản phẩm
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item->id == $delete_id) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
    }
    // Xóa toàn bộ giỏ hàng
    if (isset($_GET['clear'])) {
        unset($_SESSION['cart']);
    }
    // Cập nhật số lượng
    if (isset($_POST['update_id']) && isset($_POST['update_quantity'])) {
        $update_id = $_POST['update_id'];
        $update_quantity = intval($_POST['update_quantity']);
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item->id == $update_id) {
                $_SESSION['cart'][$key]->quantity = max(1, $update_quantity);
                break;
            }
        }
    }

    // Tính tổng tiền
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $item_total = $item->quantity * $item->price * 1000;
            $total += $item_total;
        }
    }
    $_SESSION['total'] = $total;

    // Giao diện giỏ hàng với Bootstrap
    echo '
    <section class="shoping-cart spad py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="mb-4 text-center">Giỏ hàng của bạn</h4>
                    <table class="table table-bordered text-center">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Giá tiền</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>';

    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        foreach ($_SESSION['cart'] as $item) {
            $item_total = $item->quantity * $item->price * 1000;
            echo '
            <tr>
                <td class="align-middle">
                    <div style="width: 100px; height: 100px; margin: auto;">
                        <img src="assets/images/'.$item->image.'" alt="'.$item->name.'" class="img-fluid rounded" style="object-fit: cover; width: 100%; height: 100%;">
                    </div>
                    <p class="mt-2">'.$item->name.'</p>
                </td>
                <td class="align-middle">'.number_format($item->price * 1000, 0, ',', '.').'đ</td>
                <td class="align-middle">
                    <form method="POST" class="d-inline-block">
                        <input type="number" name="update_quantity" class="form-control d-inline-block" value="'.$item->quantity.'" min="1" style="width: 70px;">
                        <input type="hidden" name="update_id" value="'.$item->id.'">
                        <button type="submit" class="btn btn-success btn-sm mt-2">Cập nhật</button>
                    </form>
                </td>
                <td class="align-middle">'.number_format($item_total, 0, ',', '.').'đ</td>
                <td class="align-middle">
                    <a href="?delete_id='.$item->id.'" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Xóa
                    </a>
                </td>
            </tr>';
        }
    } else {
        echo '
            <tr>
                <td colspan="5" class="text-center py-4">Giỏ hàng của bạn trống!</td>
            </tr>';
    }

    echo '
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6">
                    <a href="index.php" class="btn btn-outline-secondary">Tiếp tục mua sắm</a>
                </div>
                <div class="col-lg-6 text-right">
                    <h4 class="mb-3">Tổng tiền: <span class="text-danger">'.number_format($total, 0, ',', '.').'đ</span></h4>
                    <a href="?clear" class="btn btn-outline-danger">Xóa giỏ hàng</a>
                    <a href="thanhtoan.php" class="btn btn-success ml-2">Tiếp tục thanh toán</a>
                </div>
            </div>
        </div>
    </section>';
}
function _checkout($titlecheckout) {
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $total = 0;
    foreach ($cart as $item) {
        $total += $item->quantity * $item->price * 1000;
        if ($item->quantity < 1) {
            echo "Số lượng sản phẩm không hợp lệ!";
            return;
        }
    }    
    $total = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
    if ($total <= 0) {
        die("Giỏ hàng của bạn trống!");
    }

    // Thêm phí 2%
    $totalWithFee = $total + ($total * 0.02);

    $s = '
       <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <h4>' . $titlecheckout . '</h4>
                </div>
            </div>
            <div class="checkout__form">
                <form action="process_order.php" method="POST">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout__input">
                                <p>Họ Tên <span>*</span></p>
                                <input type="text" name="name" required>
                            </div>
                            <div class="checkout__input">
                                <p>Địa Chỉ <span>*</span></p>
                                <input type="text" name="address" placeholder="Nhập địa chỉ của bạn" required>
                            </div>
                            <div class="checkout__input">
                                <p>Số điện thoại <span>*</span></p>
                                <input type="text" name="phone" required>
                            </div>
                            <div class="checkout__input">
                                <p>Ghi chú</p>
                                <input type="text" name="note" placeholder="Ghi chú về đơn hàng (nếu có)">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Đơn hàng của bạn</h4>
                                <div class="checkout__order__products">Sản phẩm <span>Tổng tiền</span></div>
                                <ul>';

                                 foreach ($cart as $item) {
                                     $item_total = $item->quantity * $item->price * 1000;
                                     $s .= '<li>' . $item->name . ' x ' . $item->quantity . '<span>' . number_format($item_total, 0, ',', '.') . '<sup>đ</sup></span></li>';
                                 }

                                $s .= '</ul>
                                <div class="checkout__order__total">Tổng tiền <span>' . number_format($total, 0, ',', '.') . '<sup>đ</sup></span></div>
                                <button type="submit" class="site-btn">ĐẶT HÀNG</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    ';

    echo $s;
}

function _contact() {
    $s = '
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="fa fa-phone"></span>
                        <h4>Số điện thoại</h4>
                        <p>0368929395</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="fa fa-map-marker"></span>
                        <h4>Địa chỉ</h4>
                        <p>Thôn 3, Hòa Phú, Buôn Ma Thuột, Đắk Lắk.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="fa fa-clock-o"></span>
                        <h4>Thời gian hoạt động</h4>
                        <p>7:00 am to 23:00 pm</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="fa fa-envelope"></span>
                        <h4>Email</h4>
                        <p>hotro.enbesu@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <div class="map">
   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3893.124551700423!2d108.10606877616706!3d12.639832990236885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3171f69a5e8a734b%3A0x30a11c911c748b6b!2zVGjDtG4gMywgRWEgVGnDqnUsIFRwLiBCdcO0biBNYSBUaHXhu5l0LCDEkOG6r2sgTOG6r2ssIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1733661700211!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <div class="map-inside">
        <i class="fa fa-map-marker"></i>
        <div class="inside-widget">
            <h4>Bà Rịa Vũng Tàu, Việt Nam</h4>
            <ul>
                <li>Số điện thoại: 0368929395</li>
                <li>Địa chỉ: Thôn 3, Hòa Phú, Buôn Ma Thuột, Đắk Lắk.</li>
            </ul>
        </div>
    </div>
 </div>

    <div class="contact-form spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>Liên Hệ</h2>
                    </div>
                </div>
            </div>';

    // Xử lý form PHP
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $name = htmlspecialchars($_POST['name']);
        $message = htmlspecialchars($_POST['message']);

        if (!$email) {
            $s .= "<script>displayNotification('Email không hợp lệ!', 'error');</script>";
        } else {
            $email = Database::getConnection()->real_escape_string($email);
            $name = Database::getConnection()->real_escape_string($name);
            $message = Database::getConnection()->real_escape_string($message);
            $sql = "INSERT INTO contacts (email, message, name) VALUES ('$email', '$message', '$name')";
            if (Database::query($sql) === TRUE) {
                $s .= "<script>displayNotification('Liên hệ đã gửi thành công!', 'success');</script>";
            } else {
                $s .= "<script>displayNotification('Lỗi: " . Database::getConnection()->error . "', 'error');</script>";
            }
        }
    }
    $s .= '<form method="POST" action="">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <input type="text" name="name" placeholder="Nhập vào tên của bạn" required>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <input type="email" name="email" placeholder="Nhập vào email của bạn" required>
                    </div>
                    <div class="col-lg-12 text-center">
                        <textarea placeholder="Tin nhắn bạn gửi" name="message" required></textarea>
                        <button type="submit" class="site-btn">GỬI TIN NHẮN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    ';
    echo $s;
}
function _gioithieu($titlegioithieu) {
    $s = '
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__item">
                            <h4>'.$titlegioithieu.'</h4>
                            <div class="blog__sidebar__recent">';
                               $q1 = Database::query("SELECT * FROM `blog`");
                               while ($r1 = $q1->fetch_array()) {
                               $s .= '
                              <a href="baiviet.php?id_blog=' . intval($r1['id']) . '" class="blog__sidebar__recent__item" style="text-decoration: none;">
                             <div class="blog__sidebar__recent__item__pic">
                            <img src="img/blog/'.$r1['image'].'" alt="" width="80" height="80">
                         </div>
                         <div class="blog__sidebar__recent__item__text">
                        <h6>'.$r1['title'].'</h6>
                        <p>'.$r1['pagaph'].'</p>
                       <span>'.$r1['day'].'</span>
                      </div>
                    </a>';
                    }
                   $s .= '
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="row">';
                $q = Database::query("SELECT * FROM `baigioithieu`");
                while ($r = $q->fetch_array()) {
                 $s .= '
                <div class="col-lg-6 col-md-6 col-sm-6">
                 <div class="blog__item">
                <div class="blog__item__pic">
                    <img src="img/blog/'.$r['image'].'" alt="">
                </div>
                <div class="blog__item__text">
                    <h5><a href="baigioithieu.php?id_article=' . intval($r['id']) . '">'.$r['title'].'</a></h5>
                    <p>'.$r['pagraph'].'</p>
                    <a href="baigioithieu.php?id_article=' . intval($r['id']) . '" class="blog__btn">Xem Thêm<span class="fa fa-arrow-right"></span></a>
                </div>
            </div>
            </div>';
          }
    $s .= '
                    </div>
                </div>
            </div>
        </div>
    </section>';

    echo $s;
}
function _baiviet() {
    $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
    $s = '
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5 order-md-1 order-2">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                            <form action="" method="GET">
                                <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="'.$keyword.'">
                                <button type="submit"><span class="fa fa-search"></span></button>
                            </form>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4 style="color: #228B22; font-size: 25px; font-weight: 700;">Danh Mục</h4>
                            <ul>';
                            $q = Database::query("SELECT * FROM `categories`");
                             while ($r = $q->fetch_array()) {
                                $s .= '<li><a href="sanpham.php?id_category=' . intval($r['id']) . '">
                              <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> '.$r['name']. '</a></li>';
                               }
                             $s .= '</ul>
                        </div>
                         <div class="blog__sidebar__item">
                            <h4>Bài Viết gần đây</h4>
                            <div class="blog__sidebar__recent">';
                             $q1 = Database::query("SELECT * FROM `blog`ORDER BY `day` DESC LIMIT 5");
                             while ($r1 = $q1->fetch_array()) {
                                $s .= '<a href="baiviet.php?id_blog=' . intval($r1['id']) . '" class="blog__sidebar__recent__item" style="text-decoration: none;">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="img/blog/'.$r1['image'].'" alt="" width="150px" height="80px">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>'.$r1['title'].'</h6>
                                    <span>'.$r1['day'].'</span>
                                </div>
                            </a>';
                           }
                         $s .= '</div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Tìm kiếm bởi từ khoá</h4>
                            <div class="blog__sidebar__item__tags">';
                             $q2 = Database::query("SELECT DISTINCT id, name FROM `products` LIMIT 5");
                             while ($r2 = $q2->fetch_array()) {
                             $s .= '<a href="sanpham.php?id_product=' . intval($r2['id']) . '">'.$r2['name'].'</a>';
                            }
                        $s .= '</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 order-md-1 order-1">';
                if (!isset($_GET['id_blog'])) {
                $q = Database::query("SELECT * FROM `blog`");
                } else {
                $q = Database::query("SELECT * FROM `blog` WHERE id = " . intval($_GET['id_blog']));
                }
                while ($r = $q->fetch_array()) {
                if (!isset($_GET['id_blog'])) {
                $q1 = Database::query("SELECT * FROM `baiviet` WHERE status = true AND id_blog = " . intval($r['id']));
                } else {
                $q1 = Database::query("SELECT * FROM `baiviet` WHERE id_blog = " . intval($r['id']));
                }
               while ($r1 = $q1->fetch_array()) {
               $s .= '<div class="blog__details__text">
                    <img src="img/blog/'. $r1['image'] .'" alt="">
                    <h3>'.$r1['title'].'</h3>
                    <p>'.$r1['pagraph'].'</p>
                </div>';
        }
    }
    $s .= '</div>
            </div>
        </div>
    </section>';

    echo $s;
}
function _contactbutton() {
    $s = '
    <div class="contact-icons">
    <!-- Nút Gọi điện -->
    <a href="tel:0368929395" class="phone" title="Gọi điện">
      <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
    </a>
    <!-- Nút Zalo -->
    <a href="https://zalo.me/0368929395" class="zalo" target="_blank" title="Zalo">
      <img src="assets/images/zalo.png" width="25px" height="25px">
    </a>
  </div>
    ';
    echo $s;
}
function _article() {
    $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
    $s = '
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5 order-md-1 order-2">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                            <form action="" method="GET">
                                <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="'.$keyword.'">
                                <button type="submit"><span class="fa fa-search"></span></button>
                            </form>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4 style="color: #228B22; font-size: 25px; font-weight: 700;">Danh Mục</h4>
                            <ul>';
                            $q = Database::query("SELECT * FROM `categories`");
                             while ($r = $q->fetch_array()) {
                                $s .= '<li><a href="sanpham.php?id_category=' . intval($r['id']) . '">
                              <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> '.$r['name']. '</a></li>';
                               }
                             $s .= '</ul>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Bài Viết gần đây</h4>
                            <div class="blog__sidebar__recent">';
                             $q1 = Database::query("SELECT * FROM `blog` ORDER BY `day` DESC LIMIT 5");
                             while ($r1 = $q1->fetch_array()) {
                                $s .= '<a href="baiviet.php?id_blog=' . intval($r1['id']) . '" class="blog__sidebar__recent__item" style="text-decoration: none;">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="assets/images/'.$r1['image'].'" alt="" width="150px" height="80px">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>'.$r1['title'].'</h6>
                                    <span>'.$r1['day'].'</span>
                                </div>
                            </a>';
                           }
                         $s .= '</div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Tìm kiếm bởi từ khoá</h4>
                            <div class="blog__sidebar__item__tags">';
                             $q2 = Database::query("SELECT DISTINCT id, name FROM `products` LIMIT 5");
                             while ($r2 = $q2->fetch_array()) {
                             $s .= '<a href="sanpham.php?id_product=' . intval($r2['id']) . '">'.$r2['name'].'</a>';
                            }
                        $s .= '</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 order-md-1 order-1">';
                if (!isset($_GET['id_article'])) {
                $q = Database::query("SELECT * FROM `baigioithieu`");
                } else {
                $q = Database::query("SELECT * FROM `baigioithieu` WHERE id = " . intval($_GET['id_article']));
                }
                while ($r = $q->fetch_array()) {
                if (!isset($_GET['id_blog'])) {
                $q1 = Database::query("SELECT * FROM `article` WHERE status = true AND id_article = " . intval($r['id']));
                } else {
                $q1 = Database::query("SELECT * FROM `article` WHERE id_article = " . intval($r['id']));
                }
               while ($r1 = $q1->fetch_array()) {
               $s .= '<div class="blog__details__text">
                    <img src="img/blog/'. $r1['image'] .'" alt="">
                    <h3>'.$r1['title'].'</h3>
                    <p>'.$r1['paragraph'].'</p>
                </div>';
        }
    }
    $s .= '</div>
            </div>
        </div>
    </section>';
    echo $s;
}
function _addproductinfo($id_thongtin) {
    $id_thongtin = intval($id_thongtin);
    $q = Database::query("SELECT * FROM `thongtin` WHERE id = $id_thongtin");
    if (!$q || $q->num_rows === 0) {
        return;
    }
    $r = $q->fetch_array();
    if (!$r) {
        return;
    }
    if (isset($_SESSION['cart'])) {
        $a = $_SESSION['cart'];
        $found = false;
        foreach ($a as $key => $item) {
            if ($item->id == $r['id']) {
                $a[$key]->quantity++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $a[] = new cart($r['id'], $r['name'], $r['image'], $r['price'], 1);
        }
    } else {
        $a = [];
        $a[] = new cart($r['id'], $r['name'], $r['image'], $r['price'], 1);
    }
    $_SESSION['cart'] = $a;
}
function _thethanhvien() {
    $s = '
    <div class="container-fluid">
    <div class="row">
     <div class="col-md-3 sidebar">
      <h5 class="text-center mt-3">Chuyên Mục Bài Viết</h5>
      <a href="thanhvien.php" class="fw-bold text-bg-success">Thẻ Thành Viên</a>
      <a href="gioithieu.php">Về Enbesu</a>
     </div>
     <div class="col-md-4">
      <div class="p-4">
        <h2 class="text-success">Chính sách thẻ thành viên Enbesu</h2>';
        $q1 = Database::query("SELECT * FROM `thethanhvien`");
        while($r1 = $q1->fetch_array()) {
        $s .= '<div class="card mt-3">
          <img src="assets/images/'.$r1['image'].'" class="card-img-top" alt="Chính Sách Thẻ">
          <div class="card-body">
            <h5 class="card-title">'.$r1['title'].'</h5>
            <p class="card-text">'.$r1['pagraph'].'</p>
            <p claas="card-text">'.$r1['day'].'</p>
            <a href="the.php?id_the='. intval($r1['id']) . '" class="btn btn-success">Xem Thêm</a>
          </div>
        </div>';
        }
      $s .= '</div>
      </div>
      </div>
      </div>
      ';
      echo $s;
}
function _the() {
    $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
    $s = '
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5 order-md-1 order-2">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                            <form action="" method="GET">
                                <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="'.$keyword.'">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4 style="color: #228B22; font-size: 25px; font-weight: 700;">Danh Mục</h4>
                            <ul>';
                            $q = Database::query("SELECT * FROM `categories`");
                             while ($r = $q->fetch_array()) {
                                $s .= '<li><a href="sanpham.php?id_category=' . intval($r['id']) . '">
                              <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> '.$r['name']. '</a></li>';
                               }
                             $s .= '</ul>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Danh sách thẻ thành viên</h4>
                            <div class="blog__sidebar__recent">';
                            $q = Database::query("SELECT * FROM `thethanhvien` ORDER BY `day` DESC LIMIT 5");
                            while ($r = $q->fetch_array()) {
                                $s .= '<a href="the.php?id_the=' . intval($r['id']) . '" class="blog__sidebar__recent__item" style="text-decoration: none;">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img src="assets/images/'.$r['image'].'" alt="" width="150px" height="80px">
                                    </div>
                                    <div class="blog__sidebar__recent__item__text">
                                        <h6>'.$r['title'].'</h6>
                                        <span>'.$r['day'].'</span>
                                    </div>
                                </a>';
                            }
                            $s .= '</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 order-md-1 order-1">';
                if (!isset($_GET['id_the'])) {
                $q = Database::query("SELECT * FROM `thethanhvien`");
                } else {
                $q = Database::query("SELECT * FROM `thethanhvien` WHERE id = " . intval($_GET['id_the']));
                }
                while ($r = $q->fetch_array()) {
                if (!isset($_GET['id_the'])) {
                $q1 = Database::query("SELECT * FROM `the` WHERE status = true AND id_the = " . intval($r['id']));
                } else {
                $q1 = Database::query("SELECT * FROM `the` WHERE id_the = " . intval($r['id']));
                }
               while ($r1 = $q1->fetch_array()) {
               $s .= '<div class="blog__details__text">
                    <img src="img/blog/'. $r1['image'] .'" alt="">
                    <h3>'.$r1['title'].'</h3>
                    <p>'.$r1['pagraph'].'</p>
                </div>';
        }
    }
    $s .= '</div>
            </div>
        </div>
    </section>';
    echo $s;
}
function product($title) {
    $s = '
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>'.$title.'</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <!-- Show "Tất Cả" option -->
                            <li class="' . (!isset($_GET['id_category']) ? 'active' : '') . '">
                                <a style="color: #000; text-decoration: none;" href="index.php">Tất Cả</a>
                            </li>';
                          $categories = Database::query("SELECT * FROM `categories`");
                         while ($category = $categories->fetch_array()) {
                            $s .= '<li class="' . (isset($_GET['id_category']) && $_GET['id_category'] == $category['id'] ? 'active' : '') . '">
                <a style="color: #000; text-decoration: none;" href="index.php?id_category='.$category['id']. '">'.$category['name'].'</a>
              </li>';
               }
          $s .= '</ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">';

    if (isset($_GET['id_category']) && is_numeric($_GET['id_category'])) {
        $categoryId = intval($_GET['id_category']);
        $products = Database::query("SELECT * FROM `products` WHERE `status` = true AND `id_category` = $categoryId");
    } else {
        $products = Database::query("SELECT * FROM `products` WHERE `status` = true");
    }
    if ($products->num_rows > 0) {
        while ($product = $products->fetch_array()) {
            $productLink = isset($_SESSION['user']) ? 'sanpham.php?id_product='.$product['id']:'dangnhap.php';
            $s .= '
                <div class="col-lg-3 col-md-4 col-sm-6 mix category-'.$product['id_category'].'">
                    <div class="featured__item">
                        <!-- Product Image -->
                        <div class="featured__item__pic set-bg">
                            <a href="thongtin.php?id_info= '.intval($product['id']).'"><img src="assets/images/'.$product['image'].'" alt="'.$product['name'].'" width="100%" style="border-radius: 30px;"></a>
                            <ul class="featured__item__pic__hover" style="margin-left: -30px;">
                                 <li><a href="thongtin.php?id_info= '.intval($product['id']).'"><i class="fa-solid fa-eye"></i></a></li>
                                <li><a href="' . $productLink . '"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <!-- Product Details -->
                        <div class="featured__item__text">
                            <h6>'.$product['name'].'</h6>
                            <h5 style="text-decoration:line-through; font-weight: 500;font-family: "Lato", serif; font-size: 18px;">'.$product['price_old'].'<sup>đ</sup></h5>
                            <h5 style="color: red;">'.$product['price'].'<sup style="text-decoration: underline; font-family: "Lato", serif;">đ</sup></h5>
                        </div>
                    </div>
                </div>';
        }
    } else {
        $s .= '<p class="text-center">Không có sản phẩm nào thuộc danh mục này.</p>';
    }

    $s .= '
            </div>
        </div>
    </section>';
    echo $s;
}

function _poster() {
    $q = Database::query("SELECT * FROM `haianh`");
    $s = '';
    $counter = 0;
    while ($r = $q->fetch_array()) {
        if ($counter % 2 === 0) {
            $s .= '<div class="row">';
        }
        $s .= '
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="banner__pic">
                <img src="assets/images/' . htmlspecialchars($r['image']) . '" alt="">
            </div>
        </div>';
        $counter++;
        if ($counter % 2 === 0) {
            $s .= '</div>'; 
        }
    }
    if ($counter % 2 !== 0) {
        $s .= '</div>';
    }
    $s = '
    <div class="banner">
        <div class="container">' . $s . '</div>
    </div>';

    echo $s;
}

function _laster() {
    $s = '
    <section class="latest-product spad">
        <div class="container">
            <div class="row">';
    $q = Database::query("SELECT * FROM `categories` ORDER BY id LIMIT 3");
    while ($r = $q->fetch_array()) {
        $s .= '
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>'.$r['name'].'</h4>
                    <div class="latest-product__slider owl-carousel">';
        $q1 = Database::query("SELECT * FROM `products` WHERE `id_category` = " . intval($r['id']) . " AND `status` = true");
        $products = [];
        while ($r1 = $q1->fetch_array()) {
            $products[] = $r1;
        }
        $chunks = array_chunk($products, 3);
        foreach ($chunks as $chunk) {
            $s .= '<div class="latest-product__slider__item">';
            foreach ($chunk as $r1) {
                $link = isset($_SESSION['user']) 
                    ? 'sanpham.php?id_product=' . intval($r1['id']) 
                    : 'dangnhap.php';
                $s .= '
                            <div class="latest-product__item">
                                <a href="'.$link.'" class="latest-product__item" style="text-decoration: none;">
                                    <div class="latest-product__item__pic">
                                        <img src="assets/images/'.$r1['image'].'" alt="'.$r1['name'].'">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>'.$r1['name'].'</h6>
                                        <span>'.$r1['price'].' <sup style="text-decoration: underline;">đ</sup></span>
                                        <h5 style="text-decoration:line-through; font-weight: 500;font-family: "Lato", serif; font-size: 18px;">'.$r1['price_old'].'<sup>đ</sup></h5>
                                    </div>
                                </a>
                            </div>';
            }
            $s .= '</div>';
        }

        $s .= '</div> 
                </div>
            </div>';
    }

    $s .= '</div> 
        </div>
    </section>';
    echo $s;
}

function _slider() {
    $s = '';
    $categories_query = Database::query("SELECT * FROM `categories`");
    if ($categories_query->num_rows > 0) {
        $s .= '<section class="categories">
                   <div class="container">
                       <div class="row">
                           <div class="categories__slider owl-carousel">';
        $total_products_query = Database::query("SELECT COUNT(*) as total FROM `products`");
        $total_products = $total_products_query->fetch_assoc()['total'];
        $limit = min($total_products, 10);
        $products_query = Database::query("SELECT * FROM `products` ORDER BY RAND() LIMIT $limit");
        $products = $products_query->fetch_all(MYSQLI_ASSOC);
        while ($category = $categories_query->fetch_assoc()) {
            foreach ($products as $product) {
                $s .= '
                <div class="col-lg-3">
                    <a href="' . (isset($_SESSION['user']) ? 'index.php?id_product=' . $product['id'] : 'dangnhap.php') . '">
                        <div class="categories__item set-bg">
                            <img src="assets/images/' . $product['image'] . '" width="100%" style="border-radius: 30px;" alt="' .$product['name'].'">
                            <h5 style="font-weight: bolder; background: #fff; width: 100%;">'.$product['name'].'</h5>
                        </div>
                    </a>
                </div>';
            }
        }
        $s .= '
                           </div>
                       </div>
                   </div>
               </section>';
    }
    echo $s;
}

function user() {
    ob_start();
    ob_end_flush();
    $nameError = $phoneError = $passwordError = $confirmPasswordError = '';
    $userData = [
        'name' => '',
        'password' => '',
        'phone' => ''
    ];

    if (isset($_SESSION['user'])) {
        $userData['name'] = $_SESSION['user']['name'];
        $userData['phone'] = $_SESSION['user']['phone'];
        $userData['password'] = $_SESSION['user']['password']; 
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $userId = $_SESSION['user']['id'];

        // Handle updating name and phone
        if (isset($_POST['name']) && isset($_POST['phone'])) {
            $name = trim($_POST['name']);
            $phone = trim($_POST['phone']);
            if (empty($name)) {
                $nameError = "Vui lòng nhập tên của bạn!";
            }
            if (empty($phone)) {
                $phoneError = "Cần có số điện thoại!";
            } else if (!preg_match('/^\d{10}$/', $phone)) {
                $phoneError = "Số điện thoại phải có đúng 10 chữ số!";
            } else {
                $phoneCheckQuery = "SELECT COUNT(*) FROM users WHERE phone = '$phone' AND id != '$userId'";
                $phoneCheck = Database::query($phoneCheckQuery);
                $phoneExists = $phoneCheck->fetch_array()[0];

                if ($phoneExists > 0) {
                    $phoneError = "Số điện thoại đã tồn tại!";
                }
            }
            if (empty($nameError) && empty($phoneError)) {
                $updateQuery = "UPDATE users SET name = '$name', phone = '$phone' WHERE id = '$userId'";
                if (Database::query($updateQuery)) {
                    $_SESSION['user']['name'] = $name;
                    $_SESSION['user']['phone'] = $phone;
                    header("Location: index.php");
                    exit;
                } else {
                    echo "Lỗi khi cập nhật thông tin!";
                }
            }
        }

        // Handle password change
        if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirm_password']);
            
            // Validate password
            if (empty($password)) {
                $passwordError = "Mật khẩu không được để trống!";
            } else if (strlen($password) < 6) {
                $passwordError = "Mật khẩu phải có ít nhất 6 ký tự!";
            }
            
            // Validate confirm password
            if (empty($confirmPassword)) {
                $confirmPasswordError = "Vui lòng xác nhận mật khẩu!";
            } else if ($password !== $confirmPassword) {
                $confirmPasswordError = "Mật khẩu xác nhận không khớp!";
            }
            
            if (empty($passwordError) && empty($confirmPasswordError)) {
                $hashedPassword = $password; // Securely hash the password
                $updatePasswordQuery = "UPDATE users SET password = '$hashedPassword' WHERE id = '$userId'";
                if (Database::query($updatePasswordQuery)) {
                    $_SESSION['user']['password'] = $hashedPassword;
                    header("Location: index.php");
                    exit;
                } else {
                    echo "Lỗi khi cập nhật mật khẩu!";
                }
            }
        }
    }

    $s = '
    <main class="container my-4">
        <div class="row">
            <nav class="col-md-3">
                <div class="list-group">
                    <a href="user.php" class="list-group-item list-group-item-action active bg-success">Thông tin tài khoản</a>
                </div>
            </nav>
            <div class="col-md-9">
                <!-- Thông tin tài khoản -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        Thông tin tài khoản
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên đăng nhập:</label>
                                <input type="text" id="name" name="name" class="form-control" value="'.htmlspecialchars($userData['name']).'">
                                <div class="text-danger">'.$nameError.'</div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại:</label>
                                <input type="tel" id="phone" name="phone" class="form-control" value="'.htmlspecialchars($userData['phone']).'">
                                <div class="text-danger">'.$phoneError.'</div>
                            </div>
                            <button type="submit" class="btn btn-success">Cập nhật thông tin</button>
                        </form>
                    </div>
                </div>

                <!-- Thay đổi mật khẩu -->
                <div class="card mt-4">
                    <div class="card-header bg-success text-white">
                        Thay đổi mật khẩu
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu mới:</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <div class="text-danger">'.$passwordError.'</div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                                <div class="text-danger">'.$confirmPasswordError.'</div>
                            </div>
                            <button type="submit" class="btn btn-success">Cập nhật mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    ';
    echo $s;
}

function _info() {
    global $db;
    $s = '';
    $id_info = isset($_GET['id_info']) && is_numeric($_GET['id_info']) ? intval($_GET['id_info']) : null;
    $query = $id_info 
        ? "SELECT * FROM `products` WHERE id = $id_info" 
        : "SELECT * FROM `products` LIMIT 1";
    $q = Database::query($query);
    while ($r = $q->fetch_array()) {
        $s .= '
        <section class="product-details spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__pic">
                            <div class="product__details__pic__item">
                                <img class="product__details__pic__item--large"
                                    src="assets/images/'.($r['image'] ?? 'default.jpg').'" alt="">
                            </div>
                            <div class="product__details__pic__slider owl-carousel">';
        $q_rand = Database::query("SELECT * FROM `products` ORDER BY RAND() LIMIT 10");
        while ($r_rand = $q_rand->fetch_array()) {
            $s .= '<a href="thongtin.php?id_info='.intval($r_rand['id']).'">
                    <img src="assets/images/'.($r_rand['image'] ?? 'default.jpg').'" alt="">
                  </a>';
        }
        $s .= '</div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">';
        $q_info = Database::query("SELECT * FROM `info` WHERE id_info = ".$r['id']);
        while ($r1 = $q_info->fetch_array()) {
            $s .= '<div class="product__details__text">
                        <h3>'.$r1['name'].'</h3>
                         <span style="text-decoration: line-through;">'.$r1['price_old'].'<sup>đ</sup></span>
                        <div class="product__details__price">'.$r1['price'].'<sup>đ</sup></div>
                        <p style="font-family: \'Lato\', serif; font-size: 20px; font-weight: 500;">'.$r1['pagraph'].'</p>
                        <a href="'.(isset($_SESSION['user']) ? 'sanpham.php?id_product='.$r['id'] : 'dangnhap.php').'" class="primary-btn"><i class="fa fa-shopping-cart"></i></a>
                    </div>';
        }
        $s .= '</div>
                </div>
            </div>
        </section>';
    }
    echo $s;
}



?>


