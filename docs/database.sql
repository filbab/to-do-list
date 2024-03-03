-- Create users table
  create table `users` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `email` varchar(255) not null, `email_verified_at` timestamp null, `password` varchar(255) not null, `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  alter table `users` add unique `users_email_unique`(`email`)  
-- Create password reset tokens table
  create table `password_reset_tokens` (`email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp null, primary key (`email`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
-- Create failed jobs table
  create table `failed_jobs` (`id` bigint unsigned not null auto_increment primary key, `uuid` varchar(255) not null, `connection` text not null, `queue` text not null, `payload` longtext not null, `exception` longtext not null, `failed_at` timestamp not null default CURRENT_TIMESTAMP) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  alter table `failed_jobs` add unique `failed_jobs_uuid_unique`(`uuid`)  
-- Create personal access tokens table
  create table `personal_access_tokens` (`id` bigint unsigned not null auto_increment primary key, `tokenable_type` varchar(255) not null, `tokenable_id` bigint unsigned not null, `name` varchar(255) not null, `token` varchar(64) not null, `abilities` text null, `last_used_at` timestamp null, `expires_at` timestamp null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  alter table `personal_access_tokens` add index `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`)  
  alter table `personal_access_tokens` add unique `personal_access_tokens_token_unique`(`token`)  
-- The code above creates the default Laravel tables

-- Create task statuses table
  create table `task_statuses` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
-- Create tasks table
  create table `tasks` (`id` bigint unsigned not null auto_increment primary key, `title` varchar(255) not null, `description` text null, `status_id` bigint unsigned not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
-- Adding foreign key for status_id
  alter table `tasks` add constraint `tasks_status_id_foreign` foreign key (`status_id`) references `task_statuses` (`id`) on delete cascade  
-- Creating index 
  alter table `tasks` add index `tasks_status_id_title_index`(`status_id`, `title`)  
-- Create user task table
  create table `user_task` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned not null, `task_id` bigint unsigned not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
-- Adding foreign key for user_id
  alter table `user_task` add constraint `user_task_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade  
-- Adding foreign key for task_id
  alter table `user_task` add constraint `user_task_task_id_foreign` foreign key (`task_id`) references `tasks` (`id`) on delete cascade