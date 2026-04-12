        </div>
    </div>
</div>

<div class="min-height-page"></div>

<footer class="bottom-menu">
    <div id="footer">
        <div class="container">
            <?php if ($_SESSION['nivel'] == 1) { ?>
            <ul uk-accordion>
                <li>
                    <h3 class="uk-accordion-title"></h3>
                    <div class="uk-accordion-content">

                        <?php
                            echo "<pre>";
                            print_r($_REQUEST);
                            echo "</pre>";
                        ?>

                        <?php
                        $indicesServer = array('PHP_SELF',
                            'argv',
                            'argc',
                            'GATEWAY_INTERFACE',
                            'SERVER_ADDR',
                            'SERVER_NAME',
                            'SERVER_SOFTWARE',
                            'SERVER_PROTOCOL',
                            'REQUEST_METHOD',
                            'REQUEST_TIME',
                            'REQUEST_TIME_FLOAT',
                            'QUERY_STRING',
                            'DOCUMENT_ROOT',
                            'HTTP_ACCEPT',
                            'HTTP_ACCEPT_CHARSET',
                            'HTTP_ACCEPT_ENCODING',
                            'HTTP_ACCEPT_LANGUAGE',
                            'HTTP_CONNECTION',
                            'HTTP_HOST',
                            'HTTP_REFERER',
                            'HTTP_USER_AGENT',
                            'HTTPS',
                            'REMOTE_ADDR',
                            'REMOTE_HOST',
                            'REMOTE_PORT',
                            'REMOTE_USER',
                            'REDIRECT_REMOTE_USER',
                            'SCRIPT_FILENAME',
                            'SERVER_ADMIN',
                            'SERVER_PORT',
                            'SERVER_SIGNATURE',
                            'PATH_TRANSLATED',
                            'SCRIPT_NAME',
                            'REQUEST_URI',
                            'PHP_AUTH_DIGEST',
                            'PHP_AUTH_USER',
                            'PHP_AUTH_PW',
                            'AUTH_TYPE',
                            'PATH_INFO',
                            'ORIG_PATH_INFO') ;

                        echo '<table class="table-responsive table table-striped table-hover">' ;
                        foreach ($indicesServer as $arg) {
                            if (isset($_SERVER[$arg])) {
                                echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
                            }
                            else {
                                echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
                            }
                        }
                        echo '</table>' ;
                        ?>
                    </div>
                </li>
            </ul>
            <?php } ?>
            <hr>
            <p class="muted credit pull-left">© <?php echo date("Y"); ?> Um produto Rota 3 Agência Full - CMS v4.0</p>
            <p class="muted credit pull-right">
                <?php
                    $sql = mysql_query("SELECT * FROM _logs_acesso WHERE login = '".$_SESSION['email']."' LIMIT 1,1");
                    while($row = mysql_fetch_assoc($sql)){
                    echo "Login: " . $row['login'];
                    echo " - IP: " . $row['ip'];
                    echo " - Último Acesso: " . $row['data'];
                    }
                ?>
            </p>
        </div>
    </div>
</footer>

<!-- CDN jquery latest version -->
<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.4.min.js"><\/script>')</script>

<!-- CDN javascript extern -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.12/js/uikit.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- <script src="http://digitalbush.com/wp-content/uploads/2014/10/jquery.maskedinput.js"></script> -->
<script src="assets/js/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.1.0/jquery-confirm.min.js"></script>

<!-- Import Chart-->
<script src="assets/plugin/chart/morris.min.js"></script>
<script src="assets/plugin/chart/raphael-2.1.0.min.js"></script>

<!-- Import PASS FORCE -->
<script src="assets/js/bootstrap-strong-password.js"></script>

<!-- Include summernote js-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

<!-- Internal link javascript -->
<script src="assets/js/main.js"></script>
<script src="assets/js/function.js"></script>


</body>
</html>