variable "LabRole" {
  default = "arn:aws:iam::055653651246:role/LabRole"
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
