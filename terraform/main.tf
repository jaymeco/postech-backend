provider "aws" {
  region = var.Region
  #   shared_credentials_files = ["/home/jaymeco/.aws/credentials"]
}

terraform {
  backend "s3" {}
}

resource "aws_db_subnet_group" "db-subnet" {
  name       = "db-subnet-group"
  subnet_ids = [aws_subnet.subnet-a.id, aws_subnet.subnet-b.id]
}

resource "aws_db_instance" "mysql" {
  depends_on             = [aws_security_group.sg-database]
  allocated_storage      = 10
  instance_class         = "db.t3.micro"
  db_name                = var.DatabaseName
  engine                 = "mysql"
  engine_version         = "8.0"
  username               = var.DatabaseUserName
  password               = var.DatabasePassaword
  db_subnet_group_name   = aws_db_subnet_group.db-subnet.name
  vpc_security_group_ids = [aws_security_group.sg-database.id]
  skip_final_snapshot    = true
  publicly_accessible    = true
}

output "rds_endpoint" {
  value = aws_db_instance.mysql.endpoint
}
