<?php
class EmergencyModel extends Model
{
    protected string $table = 'emergency_numbers';

    public function active(): array
    {
        return $this->query(
            'SELECT * FROM emergency_numbers WHERE active = 1 ORDER BY sort_order, name'
        );
    }
}