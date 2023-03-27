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

    public function btnSuccess()
    {
        return "Hi";
    }
}
