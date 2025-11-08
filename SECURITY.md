# Security Policy

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=phalcon-kit_core&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=phalcon-kit_core)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=phalcon-kit_core&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=phalcon-kit_core)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=phalcon-kit_core&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=phalcon-kit_core)

## Supported Versions

The following table lists the versions of **Phalcon Kit Core** that currently receive security updates and patches.

| Version | Supported          | Notes                                                 |
| ------- | ------------------ | ----------------------------------------------------- |
| 1.1.x   | :white_check_mark: | Actively maintained, receives bug and security fixes. |
| 1.0.x   | :x:                | Deprecated, upgrade recommended.                      |
| < 1.0   | :x:                | Unsupported pre-release versions.                     |

---

## Reporting a Vulnerability

We take security seriously and appreciate responsible disclosures.

If you discover a potential security issue, please follow these steps:

1. **Do not disclose publicly.** Instead, contact the Phalcon Kit Core maintainers privately.
2. **Report via GitHub:** [Open a new issue](https://github.com/phalcon-kit/core/issues/new) and add the `security` label.
3. Include as much detail as possible, such as:

    * Description of the vulnerability
    * Steps to reproduce
    * Potential impact and severity
    * Environment (OS, PHP version, configuration)

We aim to respond to all reports and provide patches or mitigations as soon as possible.

---

## Security Practices

Phalcon Kit Core follows a defense-in-depth philosophy with a focus on:

* **Static Analysis & Code Quality:** Enforced via PHPStan, Psalm, and Qodana CI checks for type safety and secure patterns.
* **Automated Testing:** PHPUnit test suites with code coverage integrated into CI/CD pipelines.
* **Input validation and sanitization** (via Phalcon and internal helpers)
* **CSRF and XSS protection** for forms and templates
* **SQL injection prevention** through ORM-based query binding
* **Secure authentication and session management** following OWASP ASVS
* **Least privilege design** for system access and configuration
* **Automatic dependency scanning** using SonarCloud, Dependabot, and Composer audit
* **Continuous Integration security gates** via GitHub Actions and SonarCloud Quality Gates

---

## Secure Development Toolchain

Phalcon Kit Core integrates multiple security and quality tools:

| Tool                                | Purpose                                                                  |
| ----------------------------------- | ------------------------------------------------------------------------ |
| **PHPStan**                         | Static analysis for code correctness and type safety.                    |
| **Psalm**                           | Deep static analysis with taint tracking for potential vulnerabilities.  |
| **PHPUnit**                         | Automated testing framework to validate code and prevent regressions.    |
| **Qodana**                          | JetBrains-powered code quality and vulnerability inspection in CI/CD.    |
| **SonarCloud**                      | Continuous code scanning for security, reliability, and maintainability. |
| **Composer Audit**                  | Dependency vulnerability scanning.                                       |
| **Phalcon IDE Stubs & Scaffolding** | Secure, consistent framework scaffolding with IDE support.               |

These tools are part of the **Phalcon Kit CI pipeline**, ensuring every commit is automatically scanned and tested before release.

---

## Developer Guidelines

All contributors must:

* Run `composer audit`, `phpstan`, and `psalm` before submitting pull requests.
* Maintain **PHPUnit test pass** with no skipped or risky tests.
* Follow **secure coding standards** (PSR-12 + OWASP compliance).
* Avoid using deprecated PHP features or insecure functions (`eval`, `extract`, etc.).
* Ensure scaffolding and stubs generated code does not bypass validation or sanitization layers.

---

## References

* [OWASP Cheat Sheet Series](https://cheatsheetseries.owasp.org/index.html)
* [OWASP Top 10](https://owasp.org/www-project-top-ten/)
* [PHP Security Best Practices](https://phptherightway.com/#security)
* [SonarCloud Project Dashboard](https://sonarcloud.io/summary/new_code?id=phalcon-kit_core)
* [PHPStan Documentation](https://phpstan.org/)
* [Psalm Documentation](https://psalm.dev/)
* [Qodana for PHP](https://www.jetbrains.com/qodana/)
* [PHPUnit Manual](https://phpunit.de/manual/current/en/)

---

*© Phalcon Kit — Security is a shared responsibility. Thank you for helping keep our ecosystem safe.*
