resource "kubernetes_secret" "app_secret" {
  metadata {
    name = "app-secret"
  }

  data = {
    DB_PASSWORD = var.DatabasePassaword
    DB_USERNAME = var.DatabaseUserName
    DB_DATABASE = var.DatabaseName
  }
}
