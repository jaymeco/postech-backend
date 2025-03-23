resource "kubernetes_secret" "app_secret" {
  metadata {
    name = "app-secret"
  }

  data = {
    DB_PASSWORD = var.DatabasePassaword
    DB_USER     = var.DatabaseUserName
    DB_NAME     = var.DatabaseName
  }
}
