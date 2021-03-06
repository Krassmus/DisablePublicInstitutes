<?php

class DisablePublicInstitutes extends StudIPPlugin implements SystemPlugin
{
    public function __construct()
    {
        parent::__construct();

        if ($GLOBALS['auth']->auth['uid'] !== "form"
                && ($_SESSION['SessSemName']['class'] === "inst")
                && $_SESSION['SessSemName'][1]
                && !$GLOBALS['perm']->have_perm("autor")) {
            $routes = array(
                "dispatch.php/institute/overview",
                "show_bereich.php",
                "dispatch.php/calendar/instschedule",
                "plugins.php/",
                "folder.php",
                "dispatch.php/course/scm/",
                "dispatch.php/course/literature",
                "wiki.php"
            );


            foreach ($routes as $route) {
                if (stripos($_SERVER['REQUEST_URI'], $route) !== false) {
                    $GLOBALS['auth']->auth["uid"] = "form";
                    $GLOBALS['sess']->freeze();
                    header("Location: ".URLHelper::getURL($_SERVER['REQUEST_URI']));
                    die();
                }
            }
        }
    }
}