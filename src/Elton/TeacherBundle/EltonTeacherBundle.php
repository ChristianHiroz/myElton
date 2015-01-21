<?php

namespace Elton\TeacherBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EltonTeacherBundle extends Bundle
{
    /**
     * Tell Symfony that Teacher is FOSUser's son. (Teacher... Him your father !)
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
