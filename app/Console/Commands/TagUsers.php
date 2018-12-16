<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Tag;
use Illuminate\Support\Facades\Validator;

class TagUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:tags 
                            {--T|tag= : Name of the tag} 
                            {--D|detach : This will detach tag from user (default : attach)}
                            {users* : The ID of user seperated by space.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tag all specified user with a tag.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data['user_id'] = $this->argument('users');
        $tagName = strtolower($this->option('tag'));
        if($tagName == null)
        {
            $this->error('--tag=tagName need to be specified');
            return 1;
        }
        
        $validator = Validator::make($data,[            
            'user_id.*'=>'distinct|exists:Users,id'
        ]);
        
        if ($validator->fails()) {
            $this->info('Error occured. See error messages below:');
        
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        // DB::enableQueryLog();
        //The reason we did not use ORM for this action so that
        //we can reduce the amount of query made from hundred to 3 queries 
        
        if(! $this->option('detach')) {
            $bulks = [];     
            //get tag or create
            $tag = Tag::whereName($tagName)->firstOrCreate(['name'=>$tagName]);        
            //detach all from pivot
            DB::table('tag_user')->whereTagId($tag->id)->whereIn('user_id',$data['user_id'])->delete();
            
            //construct bulks data
            foreach($data['user_id'] as $id):
                $bulks[] = ['user_id'=>$id,'tag_id'=>$tag->id];
            endforeach;

            DB::table('tag_user')->insert($bulks);
                    
            $this->info('All specified user has been tagged with '.$tag->name);
                
        }

        if($this->option('detach'))
        {
            $tag = Tag::whereName($tagName)->first();

            if($tag == null)
            {
                $this->error('Unable to find tag');
                return 1;
            }

            DB::table('tag_user')->whereTagId($tag->id)->whereIn('user_id',$data['user_id'])->delete();
            $this->info('All specified user has been untagged from '.$tag->name);
        }
        
        // Check Query for optimization
        // $logs = DB::getQueryLog();
        // $this->info('Query Log');
        // foreach($logs as $log) {
        //     $this->info($log['query']);
        // }        
        
        
    }
}
