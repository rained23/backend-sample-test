<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Tag;

class ManageTag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manage:tags {--C|create} 
                                        {--R|read} 
                                        {--U|update= : updatedTag (only single tag allowed). }
                                        {--D|delete}
                                        
                                        {tags* : tagName anotherTagName ... }
                                        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backend Tags CRUD';

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
        $tags = $this->argument('tags');

        if(count(array_filter(array_only($this->options(),['create','read','update','delete']))) > 1)
        {
            $this->error('Only one option allowed.');

            return 1;
        }

        if($this->option('create'))
        {
            $this->create($tags);
            $this->info('Tags has been created');
        }

        if($this->option('read'))
        {
            $this->read($tags);            
        }        

        if($this->option('update'))
        {            
            if($this->option('update') !== "")
            {
                $this->update($tags[0],$this->option('update'));
                $this->info('Tags has been updated.');
            }
            
        }

        if($this->option('delete'))
        {
            $this->delete($tags);
            $this->info('Tags has been deleted.');

        }
        
    }

    private function create($tags)
    {
        $data = [];
        foreach($tags as $tag)
        {
            $data[] = ['name'=>$tag,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()];
            
        }        

        Tag::insert($data);

        return true;        
        
    }

    private function read($tags)
    {
        $datas = Tag::whereIn('name',$tags)->get();

        foreach($datas as $tag)
        {
            $this->info('-----');
            $columns = Schema::getColumnListing((new Tag)->getTable());
            foreach($columns as $column)
            {
                $this->info($column." : ".$tag->{$column});
            }
            $this->info('-----');
        }
        
    }

    private function update($tag, $value)
    {  
       return  Tag::whereName($tag)->update(['name'=>strtolower($value)]);

    }

    private function delete($tags)
    {
        return Tag::whereIn('name',$tags)->delete();
    }
}
