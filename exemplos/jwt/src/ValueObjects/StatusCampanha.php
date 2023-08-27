<?php 
namespace App\ValueObjects;
class StatusCampanha extends Enum 
{
    const AGENDANDA = 'AG';
    const ABERTA = 'A';
    const FINALIZADA = 'F';
    const INATIVA = 'I';
    const PUBLICADA = 'P';
}