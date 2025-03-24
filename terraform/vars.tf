variable "LabRole" {
  default = "arn:aws:iam::476809694749:role/LabRole"
}

variable "LabRoleName" {
  default = "LabRole"
}

variable "Region" {
  default = "us-east-1"
}

variable "DatabaseName" {
  default = "postech"
}

variable "DatabaseUserName" {
  default = "dev_postech"
}

variable "DatabasePassaword" {
  default = "87654321"
}

variable "DatabasePort" {
  default = "3306"
}

variable "appImage" {
  default = "476809694749.dkr.ecr.us-east-1.amazonaws.com/postech-backend:v5.1"
}

variable "eksRole" {
  default = "arn:aws:iam::476809694749:role/EMR_EC2_DefaultRole"
}

data "aws_ssm_parameter" "lambda_url" {
  name = "auth-lambda-url"
}
