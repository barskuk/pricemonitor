<?php

class Cabinet
{
    public static function getCampaignSidebarMenu() {

        $customerId = Customer::checkAuth();

        $arrCampId = Campaign::getCampaignIds($customerId);

        $result = '';

        if ($arrCampId != FALSE) {

            foreach ($arrCampId as $campId) {

                $campaign = Campaign::getCampaign($campId);

                $result .= "<nav class='navbar navbar-light mb-2' style='background-color: #e3f2fd;'>
                                <a class='navbar-brand' href='#'>" . $campaign['name'] . "</a>";

                $result .= "<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#campaign-" . $campaign['id'] . "' aria-controls='campaign-" . $campaign['id'] . "' aria-expanded='false' aria-label='Toggle navigation'>
                                <span class='navbar-toggler-icon'></span>
                            </button>";

                $result .= "<div class='collapse navbar-collapse' id='campaign-" . $campaign['id'] . "'>";

                $result .= "<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>
                                <li class='nav-item active'>
                                    <a class='nav-link' href='" . ROOTSITE . "cabinet/campaign/" . $campaign['id'] . "/dashboard'>Главная панель <span class='sr-only'>(current)</span></a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='" . ROOTSITE . "cabinet/campaign/" . $campaign['id'] . "/products/all'>Товары</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='" . ROOTSITE . "cabinet/campaign/" . $campaign['id'] . "/category/all'>Категории</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='" . ROOTSITE . "cabinet/campaign/" . $campaign['id'] . "/brands/all'>Бренды</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='" . ROOTSITE . "cabinet/campaign/" . $campaign['id'] . "/competitors/all'>Конкуренты</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='" . ROOTSITE . "cabinet/campaign/" . $campaign['id'] . "/products/add'>Новый товар</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='" . ROOTSITE . "cabinet/campaign/" . $campaign['id'] . "/products/import'>Импорт товаров</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='" . ROOTSITE . "cabinet/campaign/" . $campaign['id'] . "/settings'>Настройки</a>
                                </li>
                            </ul>";
                $result .="</div></nav>";
            }
        } else {
            $result .= 'Нет кампаний';
        }

        return $result;

    }

}