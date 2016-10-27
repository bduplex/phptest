<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>
                    <xsl:value-of select="root/channel/title"/>
                </title>
                <link href="./../css/jobs.css" rel="stylesheet" type="text/css"/>
            </head>
            <body>
                <section>

                    <header>
                        <xsl:apply-templates select="root/channel"/>
                        <xsl:variable name="total" select="count(root/channel/item)"/>
                        Total results:
                        <xsl:value-of select="$total"/>
                    </header>

                    <xsl:apply-templates select="root/channel/item"/>
                </section>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="channel">
        <xsl:choose>
            <xsl:when test="link and title">
                <xsl:element name="a">
                    <xsl:attribute name="href">
                        <xsl:value-of select="link"/>
                    </xsl:attribute>
                    <xsl:value-of select="title"/>
                </xsl:element>
            </xsl:when>
        </xsl:choose>
        <p>
            <xsl:value-of select="description"/>
        </p>
    </xsl:template>

    <xsl:template match="pubDate">
        <time>
            <xsl:value-of select="."/>
        </time>
    </xsl:template>

    <xsl:template match="item">
        <article>
            <header>
                <h2>
                    <xsl:value-of select="title"/>
                </h2>
                <h3>
                    <xsl:value-of select="category"/>
                </h3>
                <p>Published on
                    <xsl:apply-templates select="pubDate"/>
                </p>
            </header>
            <details>
                <summary>Job Details</summary>
                <xsl:value-of select="description"/>
            </details>
            <p>
                <xsl:element name="a">
                    <xsl:attribute name="href">
                        <xsl:value-of select="link"/>
                    </xsl:attribute>
                    Apply
                </xsl:element>
            </p>
        </article>
    </xsl:template>
</xsl:stylesheet>