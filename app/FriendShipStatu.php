<?php

namespace App;

enum FriendShipStatu:string
{
    case ACCEPTED = 'ACCEPTED';
    case REFUSER = 'REFUSED';
    case PENDING = 'PENDING';
}
