<?php

namespace Modules\Iplaces\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIplacesSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('iplaces::common.iplaces'), function (Item $item) {
                $item->icon('fa fa-grav');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('iplaces::places.title.places'), function (Item $item) {
                    $item->icon('fa fa-grav');
                    $item->weight(0);
                    $item->append('admin.iplaces.place.create');
                    $item->route('admin.iplaces.place.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplaces.places.index')
                    );
                });
                $item->item(trans('iplaces::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-grav');
                    $item->weight(0);
                    $item->append('admin.iplaces.category.create');
                    $item->route('admin.iplaces.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplaces.categories.index')
                    );
                });
// append


            });
        });

        return $menu;
    }
}
