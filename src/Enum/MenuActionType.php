<?php

namespace MiNutCz\Tree\Enum;

enum MenuActionType: string
{
    case DELETE = 'menu_action_delete';
    case CALLBACK = 'menu_action_callback';
    case EDIT = 'menu_action_edit';
    case CREATE = 'menu_action_create';

}