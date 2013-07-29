<?php if (!defined('APPLICATION')) exit();

// add $Configuration['Plugins']['UnreadPlus']['ShowRecentDiscussions'] = TRUE; in your config to keep the "Recent Discussions" link
$PluginInfo['UnreadPlus'] = array(
    'Name' => 'unread+',
    'Description' => 'unread+ extends discussions/unread and shows all unread discussions and discussions with unread comments',
    'Version' => '0.1',
    'Author' => 'Robin',
    'RequiredApplications' => array('Vanilla' => '>=2.1'),
    'RequiredTheme' => False, 
    'RequiredPlugins' => False,
    'License' => 'GPL'
);

class UnreadPlus extends Gdn_Plugin {
    // include all never viewed discussions
    public function DiscussionModel_BeforeGetUnread_Handler($Sender) {
        $Session = Gdn::Session();
        if ($Session->UserID > 0) {
            $Sender->SQL
                ->OrWhere('w.DateLastViewed', NULL);
        }
    }
    // add a menu item
    public function DiscussionsController_BeforeDiscussionFilters_Handler($Sender) {
        echo '<li class="UnreadDiscussions';
        if (strtolower($Sender->ControllerName) == 'discussionscontroller' && strtolower($Sender->RequestMethod) == 'unread') {
            echo ' Active';
        }
        echo '">'.Anchor(Sprite('SpUnreadDiscussions').' '.T('Unread Discussions'), '/discussions/unread').'</li>';
        if (C('Plugins.UnreadPlus.ShowRecentDiscussions') == FALSE) {
            echo '<style>ul.FilterMenu>li.Discussions{display:none;}</style>';
        }
    }
    public function DiscussionController_BeforeDiscussionFilters_Handler($Sender) {
        echo '<li class="UnreadDiscussions">';
        echo Anchor(Sprite('SpUnreadDiscussions').' '.T('Unread Discussions'), '/discussions/unread').'</li>';
        if (C('Plugins.UnreadPlus.ShowRecentDiscussions') == FALSE) {
            echo '<style>ul.FilterMenu>li.Discussions{display:none;}</style>';
        }
    }
    public function CategoriesController_BeforeDiscussionFilters_Handler($Sender) {
        echo '<li class="UnreadDiscussions">';
        echo Anchor(Sprite('SpUnreadDiscussions').' '.T('Unread Discussions'), '/discussions/unread').'</li>';
        if (C('Plugins.UnreadPlus.ShowRecentDiscussions') == FALSE) {
            echo '<style>ul.FilterMenu>li.Discussions{display:none;}</style>';
        }
    }
}
