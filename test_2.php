<?php

function recursive_array_search($needle, $haystack, $currentKey = '') {
    foreach($haystack as $key=>$value) {
        if (is_array($value)) {
            $nextKey = recursive_array_search($needle,$value, $currentKey . '[' . $key . ']');
            if ($nextKey) {
                return $nextKey;
            }
        }
        else if($value==$needle) {
            return is_numeric($key) ? $currentKey . '[' .$key . ']' : $currentKey;
        }
    }
    return false;
}


class Requirements {

    private $apartment = false;
    private $house = false;

    function __construct( $options )
    {
        if ( isset( $options['apartment'] ) ) {
            $this->apartment = $options['apartment'];
        }
        if ( isset( $options['house'] ) ) {
            $this->house = $options['house'];
        }
    }
}

class Company {

    private $name = '';
    private $rules = array();

    function __construct( $name, $rules )
    {
        $this->name = $name;
        $this->rules = $rules;
    }

    function get_name() {
        return $this->name;
    }

    function get_rules() {
        return $this->rules;
    }
}

$companies = array(
    new Company( 'Company A', array( 
                array(
                    'apartment',
                    'house',
                    'or'
                ),
                array(
                    'property_insurance',
                    'none'
                ),
                'and'
            )
        ),
    new Company( 'Company B', array( 
                array(
                    '5_door_car',
                    '4_door_car',
                    'or'
                ),
                array(
                    'drivers_licence',
                    'car_insurance',
                    'and'
                ),
                'and'
            )
        ),
    new Company( 'Company C', array( 
                array(
                    'social_security',
                    'work_permit',
                    'and'
                ),
                'none'
            )
        ),     
    new Company( 'Company D', array( 
                array(
                    'apartment',
                    'flat',
                    'house',
                    'or'
                ),
                'none'
            )
        ),                
    new Company( 'Company E', array( 
                array(
                    'drivers_licence',
                    'none'
                ),
                array(
                    '2_door_car',
                    '3_door_car',
                    '4_door_car',
                    '5_door_car',
                    'or'
                ),
                'and'
            )
        ),                
    new Company( 'Company F', array( 
                array(
                    'scooter',
                    'bike',
                    'motorcycle',
                    'or'
                ),
                array(
                    'drivers_licence',
                    'motorcycle_insurance',
                    'and'
                ),
                'and'
            )
        ),                
    new Company( 'Company G', array( 
                array(
                    'massage_qualification',
                    'liability_licence',
                    'and'
                ),
                'none'
            )
        ),                
    new Company( 'Company H', array( 
                array(
                    'storage_place',
                    'garage',
                    'or'
                ),
                'none'
            )
        ),                
    new Company( 'Company J', array( 
                array(),
                'none'
            )
        ),                
    new Company( 'Company K', array( 
                array(
                    'paypal_account',
                ),
                'and'
            )
        ),                
);

$person_rules = array( 'bike', 'drivers_licence' );

foreach ($companies as $company) {
    $rules = $company->get_rules();
    $requirements = array();

    for ($i = 0; $i < sizeof( $rules ) - 1; $i++) { 
        $match_rule = false;

        if ( sizeof( $rules[ $i ] ) > 0 ) {
            foreach ($person_rules as $person_rule) {
                if ( in_array( $person_rule, $rules[ $i ] ) ) {
                    $condition = $rules[ $i ][ sizeof( $rules[ $i ] ) - 1 ];
                    if ( $condition == 'and' ) {
                        foreach ($rules[ $i ] as $item) {
                            if ( !in_array( $item, $person_rules ) ) {
                                $match_rule = false;
                                break;
                            }
                        }
                    } else {
                        $match_rule = true;
                        break;
                    }
                }
            }
        } else {
            $match_rule = true;
        }
        $requirements[] = $match_rule;
    }

    $company_match = true;
    if ( $rules[ sizeof( $rules ) - 1 ] == 'and' ) {
        foreach ( $requirements as $requirement ) {
            if ( !$requirement ) {
                $company_match = false;
                break;
            }
        }
    } else {
        $company_match = false;
        foreach ( $requirements as $requirement ) {
            if ( $requirement ) {
                $company_match = true;
                break;
            }
        }
    }

    if ( $company_match ) {
        echo $company->get_name() . ' approved ' . PHP_EOL;
        var_dump( $requirements );
        echo '---' . PHP_EOL;
    }


}