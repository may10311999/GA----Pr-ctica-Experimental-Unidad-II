using Microsoft.AspNetCore.Authentication;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using aspnet_app.Models;

namespace aspnet_app.Controllers;

public class AccountController : Controller
{
    private readonly UserManager<IdentityUser> _userManager;
    private readonly SignInManager<IdentityUser> _signInManager;

    public AccountController(
        UserManager<IdentityUser> userManager,
        SignInManager<IdentityUser> signInManager)
    {
        _userManager = userManager;
        _signInManager = signInManager;
    }

    [HttpGet]
    public IActionResult Registro()
    {
        return View();
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Registro(string nombre, string email, string password, string passwordConfirmar)
    {
        if (password != passwordConfirmar)
        {
            ModelState.AddModelError("", "Las contrasenas no coinciden.");
            return View();
        }

        if (string.IsNullOrEmpty(nombre) || nombre.Length < 2)
        {
            ModelState.AddModelError("", "El nombre debe tener al menos 2 caracteres.");
            return View();
        }

        if (ModelState.IsValid)
        {
            var usuario = new IdentityUser
            {
                UserName = email,
                Email = email
            };

            var resultado = await _userManager.CreateAsync(usuario, password);

            if (resultado.Succeeded)
            {
                TempData["MensajeExito"] = "Registro exitoso. Inicia sesion.";
                return RedirectToAction(nameof(Login));
            }

            foreach (var error in resultado.Errors)
            {
                ModelState.AddModelError("", error.Description);
            }
        }

        return View();
    }

    [HttpGet]
    public IActionResult Login()
    {
        return View();
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Login(string email, string password)
    {
        if (ModelState.IsValid)
        {
            var resultado = await _signInManager.PasswordSignInAsync(email, password, false, lockoutOnFailure: false);

            if (resultado.Succeeded)
            {
                return RedirectToAction("Index", "Tarea");
            }

            ModelState.AddModelError("", "Credenciales incorrectas.");
        }

        return View();
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Logout()
    {
        await _signInManager.SignOutAsync();
        return RedirectToAction(nameof(Login));
    }
}
