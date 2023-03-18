<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain;

class MedicalService
{
    private function __construct(
        private readonly MedicalServiceId $id,
        private MedicalServiceName $name,
        private MedicalServiceIsActive $isActive
    ) {
    }

    public static function create(
        MedicalServiceId $id,
        MedicalServiceName $name,
        MedicalServiceIsActive $isActive
    ): self {
        return new static($id, $name, $isActive);
    }

    public static function createFromName(MedicalServiceName $name): self
    {
        return self::create(
            MedicalServiceId::none(),
            $name,
            MedicalServiceIsActive::createActive()
        );
    }

    public function id(): MedicalServiceId
    {
        return $this->id;
    }

    public function active(): MedicalServiceIsActive
    {
        return $this->isActive;
    }


    public function name(): MedicalServiceName
    {
        return $this->name;
    }

    public function rename(MedicalServiceName $name): void
    {
        $this->name = $name;
    }

    public function toggleStatus(): void
    {
        $this->isActive = new MedicalServiceIsActive(!$this->isActive);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'is_active' => $this->isActive->value(),
        ];
    }
}
