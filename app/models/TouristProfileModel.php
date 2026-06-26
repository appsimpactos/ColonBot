<?php
class TouristProfileModel extends Model
{
    protected string $table = 'tourist_profiles';

    public function findByUserId(int $userId): ?array
    {
        return $this->queryOne('SELECT * FROM tourist_profiles WHERE user_id = ? LIMIT 1', [$userId]);
    }

    public function findByWhatsapp(string $whatsapp): ?array
    {
        return $this->queryOne('SELECT * FROM tourist_profiles WHERE whatsapp = ? LIMIT 1', [$whatsapp]);
    }

    public function findByEmail(string $email): ?array
    {
        return $this->queryOne('SELECT * FROM tourist_profiles WHERE email = ? LIMIT 1', [$email]);
    }

    public function createOrUpdate(int $userId, string $name, string $whatsapp = '', string $email = ''): array
    {
        $existing = $this->findByUserId($userId);
        if ($existing) {
            $this->update($existing['id'], [
                'name' => $name,
                'whatsapp' => $whatsapp ?: $existing['whatsapp'],
                'email' => $email ?: $existing['email'],
            ]);
            return $this->find($existing['id']);
        }

        $id = $this->insert([
            'user_id' => $userId,
            'name' => $name,
            'whatsapp' => $whatsapp ?: null,
            'email' => $email ?: null,
        ]);

        return $this->find($id);
    }
}