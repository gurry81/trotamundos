<?php 
/**
* 
*/
class UserTableSeeder extends Seeder
{
	
	public function run()
	{
		DB::table("user")->delete();
		User::create(["email"=>"gurry@gmail.com","nick"=>"gurry","password"=> Hash::make("gurry")]);
		User::create(["email"=>"ale@gmail.com","nick"=>"ale","password"=> Hash::make("ale")]);

	}

}
 ?>