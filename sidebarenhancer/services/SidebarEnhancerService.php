<?php
namespace Craft;

class SidebarEnhancerService extends BaseApplicationComponent
{
    public function getAdmins()
    {
        $admins = craft()->elements->getCriteria(ElementType::User, [
            'admin' => true,
            'order' => 'id desc',
        ]);

        return $admins;
    }

    public function getAdminUsernamesAsArray()
    {
        $usernames = [];
        $admins = $this->getAdmins();

        foreach ($admins as $admin) {
            $usernames[] = $admin->username;
        }

        return $usernames;
    }

    public function shouldShowEnhancedSidebar()
    {
        $user = craft()->userSession->getUser();
        $enabledFor = craft()->plugins->getPlugin('sidebarEnhancer')->getSettings()->enabledFor;

        return craft()->request->isCpRequest()
            && $user
            && $user->admin
            && is_array($enabledFor)
            && in_array($user->username, $enabledFor);
    }
}
