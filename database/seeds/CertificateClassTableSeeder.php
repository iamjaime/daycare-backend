<?php

use Illuminate\Database\Seeder;

use App\CertificateClass as CertificateClass;

class CertificateClassTableSeeder extends Seeder {

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{	
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 1 ]);
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 2 ]);
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 3 ]);
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 4 ]);
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 5 ]);
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 6 ]);
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 7 ]);
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 8 ]);
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 9 ]);
		CertificateClass::create(['certificate_id' => 1, 'class_id' => 10 ]);
	}

}
