<?php

namespace pxgamer\GazelleToUnit3d\Tests\Functionality;

use Carbon\Carbon;
use Orchestra\Testbench\TestCase;
use pxgamer\GazelleToUnit3d\Functionality\Mapping;

class MappingTest extends TestCase
{
    private const TEST_DATE_STRING = '2017-10-15 06:06:06';

    private const TEST_STRING = 'SpaghettiTest';

    private const TEST_HASH = 'f87b9feb33b6744f0bd1cb53b6fc1f23';

    /** @test */
    public function itCanMapAUserInstance(): void
    {
        $data = new \stdClass();
        $data->Username = self::TEST_STRING;
        $data->PassHash = null;
        $data->Secret = null;
        $data->Class = 1;
        $data->Email = null;
        $data->Uploaded = 0;
        $data->Downloaded = 0;
        $data->Avatar = null;
        $data->Info = null;
        $data->Title = true;
        $data->Enabled = true;
        $data->Visible = false;
        $data->Invites = 100;
        $data->joined = self::TEST_DATE_STRING;
        $data->lastconnect = self::TEST_DATE_STRING;

        $result = Mapping::map('User', $data);

        $this->assertIsArray($result);
        $this->assertEquals(self::TEST_STRING, $result['username']);
        $this->assertNull($result['password']);
        $this->assertEquals(0, $result['uploaded']);
        $this->assertEquals(100, $result['invites']);
        $this->assertInstanceOf(Carbon::class, $result['created_at']);
    }

    /** @test */
    public function itCanMapATorrentInstance(): void
    {
        $data = new \stdClass();
        $data->info_hash = pack('H*', self::TEST_HASH);
        $data->filename = self::TEST_STRING;
        $data->Size = 0;
        $data->announce_url = null;
        $data->Description = null;
        $data->FileCount = 0;
        $data->Seeders = 0;
        $data->Leechers = 0;
        $data->data = self::TEST_DATE_STRING;
        $data->lastupdate = self::TEST_DATE_STRING;

        $result = Mapping::map('Torrent', $data);

        $this->assertIsArray($result);
        $this->assertEquals(self::TEST_HASH, $result['info_hash']);
        $this->assertEquals(0, $result['size']);
        $this->assertNull($result['announce']);
        $this->assertInstanceOf(Carbon::class, $result['created_at']);
    }
}
