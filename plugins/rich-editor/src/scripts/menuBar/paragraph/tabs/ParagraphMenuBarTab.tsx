/**
 * @author Adam (charrondev) Charron <adam.c@vanillaforums.com>
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import React from "react";
import classNames from "classnames";
import ScreenReaderContent from "@library/layout/ScreenReaderContent";
import { richEditorClasses } from "@rich-editor/editor/richEditorClasses";
import { IconForButtonWrap } from "@rich-editor/editor/pieces/IconForButtonWrap";

interface IProps {
    accessibleButtonLabel: string;
    className?: string;
    index: number;
    parentID: string;
    isMenuVisible: boolean; // The whole paragraph menu, not just this one
    toggleMenu: (callback?: () => void) => void;
    icon: JSX.Element;
    tabComponent: React.ReactNode;
    setRovingIndex: () => void;
    activeFormats: {} | boolean;
    legacyMode: boolean;
    tabIndex: 0 | -1;
    open: boolean;
    selectFirstElement: () => void;
}

/**
 * Implemented Paragraph menu bar "tab" component (which is really a menu, but looks visually mors like tabs
 */
export default class ParagraphMenuBarTab extends React.PureComponent<IProps> {
    private ID = this.props.parentID + `${this.props.parentID}-dropDown`;
    private componentID = this.ID + "-component";
    private menuID = this.ID + "-menu";
    private buttonID = this.ID + "-button";
    private toggleButtonRef: React.RefObject<HTMLButtonElement> = React.createRef();
    private handleClick = (event: React.MouseEvent) => {
        this.props.setRovingIndex();
        this.props.toggleMenu(() => {
            if (!this.props.open) {
                this.toggleButtonRef.current && this.toggleButtonRef.current.focus();
            } else {
                this.props.selectFirstElement();
            }
        });
    };

    public render() {
        const { className, isMenuVisible, toggleMenu, children, icon } = this.props;
        if (open) {
            const classes = richEditorClasses(this.props.legacyMode);

            // If the roving index matches my index, or no roving index is set and we're on the first tab
            return (
                <div id={this.componentID} className={classNames(className)}>
                    <button
                        type="button"
                        role="menuitem"
                        id={this.buttonID}
                        aria-label={this.props.accessibleButtonLabel}
                        title={this.props.accessibleButtonLabel}
                        aria-controls={this.menuID}
                        aria-expanded={isMenuVisible}
                        aria-haspopup="menu"
                        onClick={this.handleClick}
                        className={classNames(classes.button, this.props.open ? classes.topLevelButtonActive : "")}
                        tabIndex={this.props.tabIndex}
                        ref={this.toggleButtonRef}
                    >
                        <IconForButtonWrap icon={icon} />
                        <ScreenReaderContent>{this.props.accessibleButtonLabel}</ScreenReaderContent>
                    </button>
                </div>
            );
        } else {
            return null;
        }
    }

    public componentDidMount() {
        if (!this.props.open && this.props.tabIndex === 0) {
            this.toggleButtonRef.current && this.toggleButtonRef.current.focus();
        }
    }

    public componentDidUpdate() {
        if (!this.props.open && this.props.tabIndex === 0) {
            this.toggleButtonRef.current && this.toggleButtonRef.current.focus();
        }
    }

    public getMenuContentsID() {
        return this.menuID;
    }
}
