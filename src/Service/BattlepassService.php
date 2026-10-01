<?php

namespace App\Service;

use App\Entity\Battlepass;
use App\Entity\Profile;
use App\Enum\BattlepassStatus;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;

class BattlepassService
{
    public function __construct(
        private ProfileRepository $profileRepo,
        private EntityManagerInterface $em
    ) {}

    /**
     * @throws \InvalidArgumentException если валидация не прошла
     * @throws \Exception
     */
    public function create(Profile $creator, string $title, string $targetEmail, string $startDateStr, string $endDateStr):Battlepass
    {
        $target = $this->profileRepo->findOneBy(['email' => $targetEmail]);
        if ($target === null) {
            throw new \InvalidArgumentException("Профиль с Email {$targetEmail} не найден!");
        }

        if ($target === $creator){
            throw new \InvalidArgumentException("Вы не можете создать БП с самим собой!");
        }

        $battlepass = new Battlepass();
        $battlepass->setTitle($title);
        $battlepass->setPlayer1($creator);
        $battlepass->setPlayer2($target);
        $battlepass->setStartAt(new \DateTimeImmutable($startDateStr));
        $battlepass->setEndAt(new \DateTimeImmutable($endDateStr));
        $battlepass->setStatus(BattlepassStatus::PENDING);

        $this->em->persist($battlepass);
        $this->em->flush();

        return $battlepass;
    }
}
