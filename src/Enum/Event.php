<?php

namespace MiNutCz\Tree\Enum;

enum Event: string
{
    case SELECT_NODE = 'select_node.jstree';
    case DESELECT_NODE = 'deselect_node.jstree';
    case INIT = 'init.jstree';
    case LOADING = 'loading.jstree';
    case LOADED = 'loaded.jstree';
    case DESTROY = 'destroy.jstree';
    case READY = 'ready.jstree';
    case LOAD_NODE = 'load_node.jstree';
    case LOAD_ALL = 'load_all.jstree';
    case MODEL = 'model.jstree';
    case REDRAW = 'redraw.jstree';
    case BEFORE_OPEN = 'before_open.jstree';
    case OPEN_NODE = 'open_node.jstree';
    case AFTER_OPEN = 'after_open.jstree';
    case CLOSE_NODE = 'close_node.jstree';
    case AFTER_CLOSE = 'after_close.jstree';
    case OPEN_ALL = 'open_all.jstree';
    case CLOSE_ALL = 'close_all.jstree';
    case ENABLE_NODE = 'enable_node.jstree';
    case DISABLE_NODE = 'disable_node.jstree';
    case HIDE_NODE = 'hide_node.jstree';
    case SHOW_NODE = 'show_node.jstree';
    case HIDE_ALL = 'hide_all.jstree';
    case SHOW_ALL = 'show_all.jstree';
    case ACTIVATE_NODE = 'activate_node.jstree';
    case HOVER_NODE = 'hover_node.jstree';
    case DEHOVER_NODE = 'dehover_node.jstree';
    case CHANGED = 'changed.jstree';
    case SELECT_ALL = 'select_all.jstree';
    case DESELECT_ALL = 'deselect_all.jstree';
    case SET_STATE = 'set_state.jstree';
    case REFRESH_NODE = 'refresh_node.jstree';
    case REFRESH = 'refresh.jstree';
    case SET_ID = 'set_id.jstree';
    case SET_TEXT = 'set_text.jstree';
    case CREATE_NODE = 'create_node.jstree';
    case DELETE_NODE = 'delete_node.jstree';
    case MOVE_NODE = 'move_node.jstree';
    case COPY_NODE = 'copy_node.jstree';
    case CUT = 'cut.jstree';
    case COPY = 'copy.jstree';
    case PASTE = 'paste.jstree';
    case CLEAR_BUFFER = 'clear_buffer.jstree';
    case SET_THEME = 'set_theme.jstree';
    case SHOW_STRIPES = 'show_stripes.jstree';
    case HIDE_STRIPES = 'hide_stripes.jstree';
    case SHOW_DOTS = 'show_dots.jstree';
    case HIDE_DOTS = 'hide_dots.jstree';
    case SHOW_ICONS = 'show_icons.jstree';
    case HIDE_ICONS = 'hide_icons.jstree';
    case SHOW_ELLIPSIS = 'show_ellipsis.jstree';
    case HIDE_ELLIPSIS = 'hide_ellipsis.jstree';

    //CHECKBOX plugin
    case CHECKBOX_DISABLE = 'disable_checkbox.jstree';
    case CHECKBOX_ENABLE = 'enable_checkbox.jstree';
    case CHECKBOX_CHECK = 'check_node.jstree';
    case CHECKBOX_UNCHECK = 'uncheck_node.jstree';
    case CHECKBOX_CHECK_ALL = 'check_all.jstree';
    case CHECKBOX_UNCHECK_ALL = 'uncheck_all.jstree';
    //CONTEXTMENU plugin
    case CONTEXTMENU_SHOW_MENU = 'show_contextmenu.jstree';
    case CONTEXTMENU_PARSE = 'context_parse.vakata';
    case CONTEXTMENU_SHOW = 'context_show.vakata';
    case CONTEXTMENU_HIDE = 'context_hide.vakata';
    //DragNDrop plugin
    case DRAG_N_DROP_SCROLL = 'dnd_scroll.vakata';
    case DRAG_N_DROP_START = 'dns_start.vakata';
    case DRAG_N_DROP_MOVE = 'dnd_move.vakata';
    case DRAG_N_DROP_STOP = 'dnd_stop.vakata';
    //SEARCH plugin
    case SEARCH = 'search.jstree';
    case SEARCH_CLEAR = 'clear_search.jstree';
    //StatePlugin
    case STATE_READY = 'state_ready.jstree';
}