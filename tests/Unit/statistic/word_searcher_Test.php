<?php

namespace Tests\Unit\statistic;

use App\Statistic\Statistic_robot_process;
use Tests\TestCase;

class word_searcher_Test extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function test_words()
    {
        $robot = new Statistic_robot_process();
        $str_test = 'کشنده دایون بسیار تمیز آماده فروش فوری';
        $str_test = 'کشنده بادسان بسیار تمیز آماده فروش فوری';
        $result = $robot->process_text($str_test);
        echo $result['msg'];
        $this->assertTrue($result['result']);

    }
}
