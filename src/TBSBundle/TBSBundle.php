<?php

namespace TBSBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TBSBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
