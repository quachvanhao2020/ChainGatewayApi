<?php
enum Network
{
    case ETH;
    case BSC;
    case TRON;
}
function cover_to_network(string $key){
    switch ($key) {
        case "bsc":
            return Network::BSC;
            break;
        case "tron":
            return Network::TRON;
            break;
        case "eth":
        default:
        return Network::ETH;
    }
    throw new Exception();
}
