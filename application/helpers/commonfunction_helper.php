<?php

class CommonFunction
{
    public function getMenuAction($url, $act_ary)
    {
        $action = [];

        $menu_actions = $this->db->get_where('menu_action', ['action_url' => $url])->result_array();

        foreach ($menu_actions as $ma) {
            if (in_array($ma['id'], $act_ary)) {
                array_push($action, $ma);
            }
        }
        return $action;
    }

    public function actionBtn($url = false, $targetBlank = false, $htmlClass = NULL, $htmlId = NUll, $btnText = "Edit", $isConfirm = false, $confirmText = "Are you sure?", $isBtn = false)
    {
        /* 
        * $type link = a tag AND $type btn = button tag
        */
        $mainUrl = 'javascript:void(0)';
        if ($url) {
            $mainUrl = base_url($url);
        }

        if ($isBtn) {
            if ($isConfirm) {
                $btn = '<button id="' . $htmlId . '" class="' . $htmlClass . '" onClick="return confirm(' . $confirmText . ')">' . $btnText . '</button>';
            } else {
                $btn = '<button id="' . $htmlId . '" class="' . $htmlClass . '">' . $btnText . '</button>';
            }
        } else {
            if ($isConfirm) {
                $btn = '<a href="' . $mainUrl . '" id="' . $htmlId . '" class="' . $htmlClass . '" onClick="return confirm(' . "'$confirmText'" . ')">' . $btnText . '</a>';
            } else {
                if ($targetBlank) {
                    $btn = '<a href="' . $mainUrl . '" id="' . $htmlId . '" class="' . $htmlClass . '" target="_blank">' . $btnText . '</a>';
                } else {
                    $btn = '<a href="' . $mainUrl . '" id="' . $htmlId . '" class="' . $htmlClass . '">' . $btnText . '</a>';
                }
            }
        }


        return $btn;
    }
}
