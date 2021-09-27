<?php

namespace Tests;

use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase{
    use CreatesApplication;
    use MakesGraphQLRequests;
    public function testQuery(): void{
        $response = $this->graphQL('
                                    {
                                        users {
                                            id
                                            is_verified
                                            user_account_number
                                            user_account_name
                                            paystack_account_name
                                            user_bank_code
                                        }
                                    }
        ');
    }
    public function testMutation(): void{
        $response = $this->graphQL('
            mutation{
                verify(
                    user_account_name: Akin Wumi
                    user_account_number: 2009586808
                    user_bank_code: 057
                )
            }
        ');
    }
}